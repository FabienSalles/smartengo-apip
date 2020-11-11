<?php

namespace Smartengo\Domain\Article\Repository;

use Smartengo\Domain\Article\Entity\Tag;

interface TagRepository
{
    public function save(Tag $tag): void;

    public function get(string $id): Tag;

    public function remove(Tag $tag): void;
}
