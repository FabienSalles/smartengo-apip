<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\NotFoundException;

class InMemoryArticleRepository implements ArticleRepository
{
    private array $articles;

    public function save(Article $article): void
    {
        $this->articles[$article->getId()] = $article;
    }

    public function get(string $id): Article
    {
        if (!isset($this->articles[$id])) {
            throw new NotFoundException(sprintf('The Article %s does not exist', $id));
        }

        return $this->articles[$id];
    }
}
