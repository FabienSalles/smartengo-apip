<?php

namespace Smartengo\Infrastructure\Symfony\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Can be replace by a Generic UniqueProperty validator
 */
final class UniqueTag extends Constraint
{
    // will be necessary for tag update
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
