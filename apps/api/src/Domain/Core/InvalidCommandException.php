<?php

namespace Smartengo\Domain\Core;

use Symfony\Component\Validator\ConstraintViolationList;

class InvalidCommandException extends \InvalidArgumentException
{
    public function __construct(string $commandClass, ConstraintViolationList $violationList)
    {
        parent::__construct(sprintf('The command %s is invalid :  %s', $commandClass, (string) $violationList));
    }
}
