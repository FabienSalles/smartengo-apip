<?php

namespace Smartengo\Domain\Article\Entity;

use Smartengo\Domain\Article\Command\AddTag;

class Tag
{
    private string $id;
    private string $title;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $updatedAt;

    private function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function createWith(AddTag $command): self
    {
        $tag = new self();
        $tag->id = $command->id;
        $tag->title = $command->title;
        $tag->createdAt = new \DateTimeImmutable();
        $tag->updatedAt = new \DateTimeImmutable();

        return $tag;
    }
}
