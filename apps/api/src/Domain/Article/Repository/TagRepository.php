<?php

namespace Smartengo\Domain\Article\Repository;

use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Core\NotFoundException;
use Smartengo\Domain\Core\UnexpectedResultException;

interface TagRepository
{
    public function save(Tag $tag): void;

    /**
     * @throws NotFoundException
     * @throws UnexpectedResultException
     */
    public function get(string $id): Tag;

    /**
     * @throws NotFoundException
     * @throws UnexpectedResultException
     */
    public function getByTitle(string $title): Tag;

    public function remove(Tag $tag): void;
}
