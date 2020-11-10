<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command\Builder;

use Smartengo\Domain\Article\Command\UpdateArticle;

class UpdateArticleBuilder extends ArticleBuilder
{
    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): UpdateArticle
    {
        $command = new UpdateArticle();
        $this->buildArticle($command);

        return $command;
    }
}
