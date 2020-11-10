<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

class AddArticleTest extends ArticleTest
{
    public function getBuilder(): ArticleBuilder
    {
        return new AddArticleBuilder();
    }

    public function getCommandClass(): string
    {
        return AddArticle::class;
    }
}
