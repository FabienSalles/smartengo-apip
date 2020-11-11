<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;

trait TagTrait
{
    private TagRepository $tagRepository;

    protected function createTag(): Tag
    {
        $tag = Tag::createWith((new AddTagBuilder())->build());
        self::$container->get(TagRepository::class)->save($tag);

        return $tag;
    }
}
