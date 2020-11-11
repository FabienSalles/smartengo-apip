<?php

namespace Smartengo\Tests\Unit\Domain\Article;

use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;

trait TagTrait
{
    protected TagRepository $tagRepository;

    /**
     * @before
     */
    protected function setUpTagRepository(): void
    {
        $this->tagRepository = InMemoryTagRepository::getInstance();
    }

    protected function createTag(): Tag
    {
        $tag = Tag::createWith((new AddTagBuilder())->build());
        $this->tagRepository->save($tag);

        return $tag;
    }
}
