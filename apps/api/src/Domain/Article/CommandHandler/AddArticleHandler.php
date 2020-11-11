<?php

namespace Smartengo\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Core\InvalidCommandException;
use Symfony\Component\Validator\ConstraintViolationList;

class AddArticleHandler extends ArticleHandler
{
    public function __invoke(AddArticle $command): void
    {
        /** @var ConstraintViolationList $violations */
        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            throw new InvalidCommandException(AddArticle::class, $violations);
        }

        $article = Article::createWith($command);
        $article->withTags($this->retrieveTags($command));

        $this->repository->save($article);
    }
}
