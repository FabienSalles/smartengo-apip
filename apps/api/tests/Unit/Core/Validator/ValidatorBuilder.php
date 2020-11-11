<?php

namespace Smartengo\Tests\Unit\Core\Validator;

use Smartengo\Domain\Core\Builder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorBuilder implements Builder
{
    private \Symfony\Component\Validator\ValidatorBuilder $validatorBuilder;

    private const VALIDATOR_FILE = 'config/validator/validation.yaml';

    public function __construct()
    {
        $this->validatorBuilder = Validation::createValidatorBuilder()->addYamlMapping(self::VALIDATOR_FILE);
    }

    public function build(): ValidatorInterface
    {
        return $this->validatorBuilder->getValidator();
    }
}
