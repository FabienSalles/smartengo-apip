<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

class AddArticleTest extends ArticleTest
{
    public function getBuilder(): ArticleBuilder
    {
        return new AddArticleBuilder();
    }
}
