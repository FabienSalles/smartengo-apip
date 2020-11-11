<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Tests\Functional\Api\ApiTestCase;

abstract class TagTest extends ApiTestCase
{
    protected function getRepository(): TagRepository
    {
        /** @var TagRepository $repository */
        $repository = self::$container->get(TagRepository::class);

        return $repository;
    }
}
