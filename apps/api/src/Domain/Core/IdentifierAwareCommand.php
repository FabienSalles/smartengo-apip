<?php

namespace Smartengo\Domain\Core;

abstract class IdentifierAwareCommand
{
    public string $id;

    public function __construct()
    {
        $this->id = Identifier::generate();
    }
}
