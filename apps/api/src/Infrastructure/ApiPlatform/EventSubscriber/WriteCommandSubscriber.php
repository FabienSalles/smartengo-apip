<?php

namespace Smartengo\Infrastructure\ApiPlatform\EventSubscriber;

use ApiPlatform\Core\Api\IriConverterInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use ApiPlatform\Core\EventListener\WriteListener;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\Util\RequestAttributesExtractor;
use Smartengo\Domain\Core\IdentifierAwareCommand;
use Smartengo\Infrastructure\ApiPlatform\Messenger\DataPersister\CommandDataPersister;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Replacement of WriteListener of Api Platform in order to not use the return of writing action but just the identifier pass through it.
 *
 * The utility is to  :
 *  * not wait the writing action
 *  * create the uri differently
 *  * respect the Command pattern and don't return the resource by the command handler
 */
final class WriteCommandSubscriber implements EventSubscriberInterface
{
    public const OPERATION_ATTRIBUTE_KEY = 'write_command';

    private CommandDataPersister $dataPersister;
    private IriConverterInterface $iriConverter;
    private ResourceMetadataFactoryInterface $resourceMetadataFactory;

    public function __construct(
        CommandDataPersister $dataPersister,
        IriConverterInterface $iriConverter,
        ResourceMetadataFactoryInterface $resourceMetadataFactory
    ) {
        $this->dataPersister = $dataPersister;
        $this->iriConverter = $iriConverter;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['__invoke', EventPriorities::PRE_WRITE],
        ];
    }

    public function __invoke(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();
        $request = $event->getRequest();
        $attributes = RequestAttributesExtractor::extractAttributes($request);

        if (!$this->isSupported($request, $attributes, $controllerResult)) {
            return;
        }

        $resourceMetadata = $this->resourceMetadataFactory->create($attributes['resource_class']);
        $writeResource = $resourceMetadata->getAttribute('write_resource', $attributes['resource_class']);

        if (!$this->dataPersister->supports($controllerResult, $attributes)) {
            throw new \RuntimeException('Command data persister does not support this request, you should use default write listener instead');
        }

        switch ($request->getMethod()) {
            case 'PUT':
            case 'PATCH':
            case 'POST':
                $$this->dataPersister->persist($controllerResult);
                $event->setControllerResult(null);
                $request->attributes->set('_api_write_item_iri', $this->iriConverter->getItemIriFromResourceClass($writeResource, [$controllerResult->id]));
                break;
            case 'DELETE':
                throw new \RuntimeException('Use the default write listener instead of this one');
        }
    }

    /**
     * @param mixed $controllerResult
     */
    private function isSupported(Request $request, array $attributes, $controllerResult): bool
    {
        return $controllerResult instanceof IdentifierAwareCommand
            && !$request->isMethodSafe()
            && $attributes['persist']
            && !$this->isOperationAttributeDisabled($attributes, self::OPERATION_ATTRIBUTE_KEY)
            && $this->isOperationAttributeDisabled($attributes, WriteListener::OPERATION_ATTRIBUTE_KEY)
            ;
    }

    private function isOperationAttributeDisabled(array $attributes, string $attribute, bool $default = false, bool $resourceFallback = true): bool
    {
        $resourceMetadata = $this->resourceMetadataFactory->create($attributes['resource_class']);

        return !((bool) $resourceMetadata->getOperationAttribute($attributes, $attribute, !$default, $resourceFallback));
    }
}
