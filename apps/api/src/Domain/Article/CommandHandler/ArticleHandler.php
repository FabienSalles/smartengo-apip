<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\CommandHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ArticleHandler implements CommandHandler
{
    protected ArticleRepository $repository;
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, ArticleRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }
}
