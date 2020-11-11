<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Smartengo\Tests\Unit\Domain\Article\Command\Builder\UpdateArticleBuilder;

class UpdateArticleTest extends ArticleTest
{
    protected function getBuilder(): UpdateArticleBuilder
    {
        return new UpdateArticleBuilder();
    }
}
