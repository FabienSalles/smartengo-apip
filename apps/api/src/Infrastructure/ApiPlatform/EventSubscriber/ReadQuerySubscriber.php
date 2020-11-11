<?php

namespace Smartengo\Infrastructure\ApiPlatform\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\EventListener\ReadListener;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\Util\RequestAttributesExtractor;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Smartengo\Domain\Core\QueryBus;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Replacement of the ReadListener in order to follow CQRS Principle and use a Query/QueryHandler concept
 * We also add validation on parameters.
 */
final class ReadQuerySubscriber implements EventSubscriberInterface
{
    public const OPERATION_ATTRIBUTE_KEY = 'read_query';

    private QueryBus $queryBus;
    private ValidatorInterface $validator;
    private ResourceMetadataFactoryInterface $resourceMetadataFactory;

    public function __construct(
        QueryBus $queryBus,
        ValidatorInterface $validator,
        ResourceMetadataFactoryInterface $resourceMetadataFactory
    ) {
        $this->queryBus = $queryBus;
        $this->validator = $validator;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['__invoke', EventPriorities::POST_VALIDATE], // should be called after the custom controller
        ];
    }

    public function __invoke(ViewEvent $viewEvent): void
    {
        $request = $viewEvent->getRequest();
        $attributes = RequestAttributesExtractor::extractAttributes($request);

        if (!$this->isSupported($request, $attributes)) {
            return;
        }

        $query = $viewEvent->getControllerResult();

        $this->validator->validate($query);

        $result = $this->queryBus->handle($query);
        $request->attributes->set('data', $result);
        $viewEvent->setControllerResult($result);
    }

    private function isSupported(Request $request, array $attributes): bool
    {
        return !empty($attributes)
            && $request->isMethod('GET')
            && !$this->isOperationAttributeDisabled($attributes, self::OPERATION_ATTRIBUTE_KEY)
            && $this->isOperationAttributeDisabled($attributes, ReadListener::OPERATION_ATTRIBUTE_KEY);
    }

    private function isOperationAttributeDisabled(array $attributes, string $attribute, bool $default = false, bool $resourceFallback = true): bool
    {
        $resourceMetadata = $this->resourceMetadataFactory->create($attributes['resource_class']);

        return !((bool) $resourceMetadata->getOperationAttribute($attributes, $attribute, !$default, $resourceFallback));
    }
}
