<?php

namespace Smartengo\Domain\Article\QueryHandler;

use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Query\GetOneArticle;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\InvalidQueryException;
use Smartengo\Domain\Core\QueryHandler;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetOneArticleHandler implements QueryHandler
{
    protected ArticleRepository $repository;
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, ArticleRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function __invoke(GetOneArticle $query): Article
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($query);

        if ($violations->count()) {
            throw new InvalidQueryException(GetOneArticle::class, $violations);
        }

        return $this->repository->get($query->id);
    }
}
