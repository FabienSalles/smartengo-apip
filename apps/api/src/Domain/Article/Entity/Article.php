<?php

namespace Smartengo\Domain\Article\Entity;

use Smartengo\Domain\Article\Command\AddArticle;

class Article
{
    private string $id;
    private string $name;
    private string $reference;
    private string $content;
    private bool $draft;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    private function __construct()
    {
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function createWith(AddArticle $command): self
    {
        $article = new self();
        $article->id = $command->id;
        $article->name = $command->name;
        $article->reference = $command->reference;
        $article->content = $command->content;
        $article->draft = $command->draft;
        $article->createdAt = new \DateTimeImmutable();
        $article->updatedAt = new \DateTimeImmutable();

        return $article;
    }
}
