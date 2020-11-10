<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command\Builder;

use Smartengo\Domain\Article\Command\AddArticle;

class AddArticleBuilder extends ArticleBuilder
{
    public function build(): AddArticle
    {
        $command = new AddArticle();
        $this->buildArticle($command);

        return $command;
    }
}
