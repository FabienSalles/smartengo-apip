<?php

namespace Smartengo\Domain\Article\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\Command\UpdateArticle;

class Article
{
    private string $id;
    private string $name;
    private string $reference;
    private string $content;
    private bool $draft;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;
    private Collection $tags;

    private function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function isDraft(): bool
    {
        return $this->draft;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function withTags(array $tags): self
    {
        $this->tags = new ArrayCollection($tags);

        return $this;
    }

    public function updateWith(UpdateArticle $command): self
    {
        self::setCommonProperties($this, $command);

        return $this;
    }

    private static function setCommonProperties(self $article, \Smartengo\Domain\Article\Command\Article $command): self
    {
        $article->name = $command->name;
        $article->reference = $command->reference;
        $article->content = $command->content;
        $article->draft = $command->draft;
        $article->updatedAt = new \DateTimeImmutable();

        return $article;
    }

    public static function createWith(AddArticle $command): self
    {
        $article = new self();
        $article->id = $command->id;
        $article->createdAt = new \DateTimeImmutable();

        self::setCommonProperties($article, $command);

        return $article;
    }
}
