<?php

namespace Smartengo\Infrastructure\ApiPlatform\Action;

use Symfony\Component\HttpFoundation\RequestStack;

final class InitializeCommandAction
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function __invoke(object $data = null): object
    {
        if (null === $data && null !== $this->requestStack->getCurrentRequest()) {
            $class = $this->requestStack->getCurrentRequest()->attributes->get('_api_resource_class');
            $data = new $class();
        }

        return $data;
    }
}
