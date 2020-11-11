<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\CommandHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class ArticleHandler implements CommandHandler
{
    protected ArticleRepository $repository;
    protected TagRepository $tagRepository;
    protected ValidatorInterface $validator;

    public function __construct(
        ValidatorInterface $validator,
        ArticleRepository $repository,
        TagRepository $tagRepository
    ) {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->tagRepository = $tagRepository;
    }

    protected function retrieveTags(Article $article): array
    {
        return array_map(fn (string $id) => $this->tagRepository->get($id), $article->tags);
    }
}
