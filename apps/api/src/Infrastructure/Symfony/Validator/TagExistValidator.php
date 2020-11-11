<?php


namespace Smartengo\Infrastructure\Symfony\Validator;


use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TagExistValidator extends ConstraintValidator
{
    private TagRepository $repository;

    public function __construct(TagRepository $repository)
    {
        $this->repository = $repository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        try {
            $this->repository->get($value);
        } catch (NotFoundException $e) {
            $this->context->buildViolation($e->getMessage())
                ->setInvalidValue($value)
                ->addViolation();
        }
    }
}
