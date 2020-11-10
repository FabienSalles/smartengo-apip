<?php

namespace Smartengo\Domain\Core;

use Symfony\Component\Uid\Uuid;

class Identifier
{
    public static function generate(): string
    {
        return Uuid::v4();
    }
}
