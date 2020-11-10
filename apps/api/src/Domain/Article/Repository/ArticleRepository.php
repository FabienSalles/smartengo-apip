<?php

namespace Smartengo\Domain\Article\Repository;

use Smartengo\Domain\Article\Entity\Article;

interface ArticleRepository
{
    public function save(Article $article): void;

    public function find(string $id): Article;
}
