<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\CommandHandler;
use Smartengo\Domain\Core\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddArticleHandler implements CommandHandler
{
    private ArticleRepository $repository;

    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, ArticleRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function __invoke(AddArticle $command): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            throw new InvalidCommandException(AddArticle::class, $violations);
        }

        $article = Article::createWith($command);
        $this->repository->save($article);
    }
}
