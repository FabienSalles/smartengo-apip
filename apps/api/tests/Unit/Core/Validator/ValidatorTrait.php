<?php

namespace Smartengo\Tests\Unit\Core\Validator;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidatorTrait
{
    protected function getValidator(): ValidatorInterface
    {
        return (new ValidatorBuilder())
            ->build();
    }

    /**
     * @return ConstraintViolation[]
     */
    protected function findViolationsByPropertyName(
        ConstraintViolationListInterface $violations,
        string $property
    ): array {
        return array_filter(
            iterator_to_array($violations),
            static fn (ConstraintViolation $violation) => $property === $violation->getPropertyPath()
        );
    }
}
