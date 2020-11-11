<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\DeleteArticle;
use Smartengo\Domain\Core\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationList;

class DeleteArticleHandler extends ArticleHandler
{
    public function __invoke(DeleteArticle $command): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            throw new InvalidCommandException(DeleteArticle::class, $violations);
        }

        $article = $this->repository->get($command->id);

        $this->repository->remove($article);
    }
}
