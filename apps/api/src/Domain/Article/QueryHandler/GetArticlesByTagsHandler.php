<?php

namespace Smartengo\Domain\Article\QueryHandler;

use Smartengo\Domain\Article\Query\GetArticlesByTags;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\InvalidQueryException;
use Smartengo\Domain\Core\QueryHandler;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GetArticlesByTagsHandler implements QueryHandler
{
    protected ArticleRepository $repository;
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator, ArticleRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function __invoke(GetArticlesByTags $query): array
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($query);

        if ($violations->count()) {
            throw new InvalidQueryException(GetArticlesByTags::class, $violations);
        }

        return $this->repository->getByTags($query->tags);
    }
}
