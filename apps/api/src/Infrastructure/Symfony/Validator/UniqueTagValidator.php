<?php

namespace Smartengo\Infrastructure\Symfony\Validator;

use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueTagValidator extends ConstraintValidator
{
    private TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        if (!$this->valueIsUnique($value)) {
            $this->context->buildViolation(sprintf('The title %s of the tag is already used', $value))
                ->setInvalidValue($value)
                ->addViolation();
        }
    }

    protected function valueIsUnique(string $value): bool
    {
        try {
            $this->repository->getByTitle($value);
        } catch (NotFoundException $e) {
            return true;
        }

        return false;
    }
}
