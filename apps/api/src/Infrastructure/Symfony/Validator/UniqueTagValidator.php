<?php

namespace Smartengo\Infrastructure\Symfony\Validator;

use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueTagValidator extends ConstraintValidator
{
    private TagRepository $repository;
    private PropertyAccessorInterface $propertyAccessor;

    public function __construct(
        TagRepository $repository,
        PropertyAccessorInterface $propertyAccessor
    ) {
        $this->repository = $repository;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * @param mixed                     $object
     * @param Constraint|UniqueTag $constraint
     */
    public function validate($object, Constraint $constraint)
    {
        $value = $this->getValue($object);

        if (null === $value) {
            return;
        }

        if (!$this->valueIsUnique($value)) {
            $this->context->buildViolation(sprintf('The title %s of the tag is already used', $value))
                ->atPath('title')
                ->setInvalidValue($value)
                ->addViolation();
        }
    }

    protected function valueIsUnique($value): bool
    {
        try {
            $this->repository->getByTitle($value);
        } catch (NotFoundException $e) {
            return true;
        }

        return false;
    }

    private function getValue($object)
    {
        return $this->propertyAccessor->getValue($object, 'title');
    }
}
