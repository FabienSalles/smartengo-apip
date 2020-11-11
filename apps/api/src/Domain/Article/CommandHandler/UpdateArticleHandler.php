<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\UpdateArticle;
use Smartengo\Domain\Core\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationList;

class UpdateArticleHandler extends ArticleHandler
{
    public function __invoke(UpdateArticle $command): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            throw new InvalidCommandException(UpdateArticle::class, $violations);
        }

        $article = $this->repository->get($command->id);
        $article->updateWith($command);

        $this->repository->save($article);
    }
}
