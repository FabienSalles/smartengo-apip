<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Smartengo\Domain\Article\Command\UpdateArticle;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\UpdateArticleBuilder;

class UpdateArticleTest extends ArticleTest
{
    protected function getBuilder(): UpdateArticleBuilder
    {
        return new UpdateArticleBuilder();
    }

    public function getCommandClass(): string
    {
        return UpdateArticle::class;
    }
}
