<?php

namespace Smartengo\Infrastructure\Repository\Article;

use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\NotFoundException;

class InMemoryTagRepository implements TagRepository
{
    private array $tags = [];

    private static ?self $instance = null;

    public function __construct()
    {
        self::$instance = $this;
    }

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

    public function getByTitle(string $title): Tag
    {

        $tag = current(array_filter($this->tags, fn(Tag $tag) => $title === $tag->getTitle()));

        if (false === $tag) {
            throw new NotFoundException(sprintf('The Tag with a title %s does not exist', $title));
        }

        return $tag;
    }

    public function remove(Tag $tag): void
    {
        unset($this->tags[$tag->getId()]);
    }

    public static function getInstance(): self
    {
        return self::$instance ?: new self();
    }
}
