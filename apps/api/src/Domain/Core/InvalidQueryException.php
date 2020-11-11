<?php

namespace Smartengo\Domain\Core;

use Symfony\Component\Validator\ConstraintViolationList;

class InvalidQueryException extends \InvalidArgumentException
{
    public function __construct(string $commandClass, ConstraintViolationList $violationList)
    {
        parent::__construct(sprintf('The query %s is invalid :  %s', $commandClass, (string) $violationList));
    }
}
