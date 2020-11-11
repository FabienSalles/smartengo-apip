<?php

namespace Smartengo\Tests\Unit\Core\Validator;

use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Infrastructure\Symfony\Validator\TagExistValidator;
use Smartengo\Infrastructure\Symfony\Validator\UniqueTagValidator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\ValidatorException;

class StubConstraintValidatorFactory implements ConstraintValidatorFactoryInterface
{
    private array $stubValidators;
    private array $validators = [];

    public function __construct()
    {
        $tagRepository = InMemoryTagRepository::getInstance();

        $this->stubValidators = [
            TagExistValidator::class => new TagExistValidator($tagRepository),
            UniqueTagValidator::class => new UniqueTagValidator($tagRepository),
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws ValidatorException      When the validator class does not exist
     * @throws UnexpectedTypeException When the validator is not an instance of ConstraintValidatorInterface
     */
    public function getInstance(Constraint $constraint)
    {
        $name = $constraint->validatedBy();

        if (!isset($this->validators[$name])) {
            if (!class_exists($name)) {
                throw new ValidatorException(sprintf('Constraint validator "%s" does not exist or is not enabled. Check the "validatedBy" method in your constraint class "%s".', $name, get_debug_type($constraint)));
            }

            $this->validators[$name] = $this->stubValidators[$name] ?? new $name();
        }

        if (!$this->validators[$name] instanceof ConstraintValidatorInterface) {
            throw new UnexpectedTypeException($this->validators[$name], ConstraintValidatorInterface::class);
        }

        return $this->validators[$name];
    }
}
