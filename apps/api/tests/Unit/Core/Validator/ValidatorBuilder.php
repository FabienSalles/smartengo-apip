<?php

namespace Smartengo\Tests\Unit\Core\Validator;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\Command\UpdateArticle;
use Smartengo\Domain\Article\Query\GetOneArticle;
use Smartengo\Domain\Core\Builder;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorBuilder implements Builder
{
    private \Symfony\Component\Validator\ValidatorBuilder $validatorBuilder;

    private const BASE_VALIDATOR = 'config/validator/';
    private const ARTICLE_VALIDATORS = self:: BASE_VALIDATOR.'article.yml';

    private const MAPPING = [
        AddArticle::class => self::ARTICLE_VALIDATORS,
        UpdateArticle::class => self::ARTICLE_VALIDATORS,
        GetOneArticle::class => self::ARTICLE_VALIDATORS,
    ];

    public function __construct()
    {
        $this->validatorBuilder = Validation::createValidatorBuilder();
    }

    public function withEntity(string $entityClass): self
    {
        $this->validatorBuilder->addYamlMapping(self::MAPPING[$entityClass]);

        return $this;
    }

    public function build(): ValidatorInterface
    {
        return $this->validatorBuilder->getValidator();
    }
}
