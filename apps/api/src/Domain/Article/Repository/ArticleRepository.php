<?php

namespace Smartengo\Domain\Article\Repository;

use Smartengo\Domain\Article\Entity\Article;

interface ArticleRepository
{
    public function save(Article $article): void;

    public function get(string $id): Article;

    public function getAll(): array;

    public function getByTags(array $tags): array;

    public function remove(Article $article): void;
}
