<?php

namespace Smartengo\Tests\Unit\Domain\Article\Query\Builder;

use Smartengo\Domain\Article\Query\GetOneArticle;
use Smartengo\Domain\Core\Builder;
use Smartengo\Domain\Core\Identifier;

class GetOneArticleBuilder implements Builder
{
    private string $id;

    public function __construct(string $id = null)
    {
        $this->id = $id ?? Identifier::generate();
    }

    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): GetOneArticle
    {
        $query = new GetOneArticle();
        $query->id = $this->id;

        return $query;
    }
}
