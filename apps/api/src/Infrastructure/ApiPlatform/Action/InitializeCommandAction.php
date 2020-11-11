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

    public function __invoke(object $data = null): ?object
    {
        if (null === $this->requestStack->getCurrentRequest()) {
            return $data;
        }

        if (null === $data) {
            $class = $this->requestStack->getCurrentRequest()->attributes->get('_api_resource_class');
            $data = new $class();
        }

        foreach ($this->requestStack->getCurrentRequest()->attributes->all() as $name => $value) {
            if (property_exists(\get_class($data), $name)) {
                $data->$name = $value;
            }
        }

        foreach ($this->requestStack->getCurrentRequest()->query->all() as $name => $value) {
            if (property_exists(\get_class($data), $name)) {
                $data->$name = $value;
            }
        }

        return $data;
    }
}
