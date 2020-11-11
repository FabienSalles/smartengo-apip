<?php

namespace Smartengo\Domain\Article\Query;

class GetArticlesByTags
{
    public array $tags;

    public function __construct(array $tags = [])
    {
        $this->tags = $tags;
    }
}
