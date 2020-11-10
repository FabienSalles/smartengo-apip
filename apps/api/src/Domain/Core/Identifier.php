<?php

namespace Smartengo\Domain\Core;

use Symfony\Component\Uid\Uuid;

class Identifier
{
    public const PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    public static function generate(): string
    {
        return Uuid::v4();
    }
}
