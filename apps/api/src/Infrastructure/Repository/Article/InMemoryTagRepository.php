<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;

class InMemoryTagRepository implements TagRepository
{
    private array $tags;

    public function save(Tag $tag): void
    {
        $this->tags[$tag->getId()] = $tag;
    }

    public function get(string $id): Tag
    {
        if (!isset($this->tags[$id])) {
            throw new NotFoundException(sprintf('The Article %s does not exist', $id));
        }

        return $this->tags[$id];
    }

    public function remove(Tag $tag): void
    {
        unset($this->tags[$tag->getId()]);
    }
}
