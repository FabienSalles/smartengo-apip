<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Entity\Tag;
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

    public function getByTags(array $tags): array
    {
        return array_filter(
            $this->articles,
            static fn (Article $article) => count(
                array_intersect($tags, array_map(
                    static fn (Tag $tag) => $tag->getTitle(),
                    $article->getTags()->toArray()
                ))
            )
        );
    }

    public function getAll(): array
    {
        return array_values($this->articles);
    }

    public function remove(Article $article): void
    {
        unset($this->articles[$article->getId()]);
    }
}
