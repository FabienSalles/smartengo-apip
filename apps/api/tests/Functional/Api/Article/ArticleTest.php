<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Tests\Functional\Api\ApiTestCase;

abstract class ArticleTest extends ApiTestCase
{
    protected function getRepository(): ArticleRepository
    {
        /** @var ArticleRepository $repository */
        $repository = self::$container->get(ArticleRepository::class);

        return $repository;
    }
}
