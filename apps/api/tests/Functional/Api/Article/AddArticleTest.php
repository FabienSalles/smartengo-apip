<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Faker\Factory;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Tests\Functional\Api\ApiTestCase;
use Smartengo\Tests\Functional\Api\Route;
use Symfony\Component\HttpFoundation\Request;

class AddArticleTest extends ApiTestCase
{
    /**
     * @test
     */
    public function validArticleShouldBeAdded(): void
    {
        $faker = Factory::create();
        $response = static::createClient()->request(Request::METHOD_POST, Route::ARTICLE, [
            'headers' => ['content-type' => 'application/ld+json'],
            'body' => json_encode([
                'name' => $faker->name,
                'reference' => $faker->company,
                'content' => $faker->text,
                'draft' => $faker->boolean,
            ], JSON_THROW_ON_ERROR),
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertUriExist(Route::ARTICLE, $response);

        // should throw an exception if the article is not find
        $this->getRepository()->find($this->getUriIdentifier(Route::ARTICLE, $response));
    }

    /**
     * @test
     */
    public function invalidArticleShouldRenderAnError(): void
    {
        $faker = Factory::create();
        $response = static::createClient()->request(Request::METHOD_POST, Route::ARTICLE, [
            'headers' => ['content-type' => 'application/ld+json'],
            'body' => json_encode([
                'reference' => $faker->company,
                'content' => $faker->text,
                'draft' => $faker->boolean,
            ], JSON_THROW_ON_ERROR),
        ]);

        self::assertResponseStatusCodeSame(400);
        self::assertJsonContains(
            [
                '@context' => '/contexts/ConstraintViolationList',
                '@type' => 'ConstraintViolationList',
                'hydra:title' => 'An error occurred',
                'violations' => [
                    [
                        'propertyPath' => 'name',
                        'message' => 'This value should not be blank.',
                    ],
                ],
            ]
        );
    }

    private function getRepository(): ArticleRepository
    {
        /** @var ArticleRepository $repository */
        $repository = self::$container->get(ArticleRepository::class);

        return $repository;
    }
}
