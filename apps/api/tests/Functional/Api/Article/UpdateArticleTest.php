<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Faker\Factory;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Tests\Functional\Api\Route;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Symfony\Component\HttpFoundation\Request;

class UpdateArticleTest extends ArticleTest
{
    /**
     * @test
     */
    public function validArticleShouldBeUpdated(): void
    {
        $article = $this->buildArticle();
        $faker = Factory::create();
        $response = static::$client->request(
            Request::METHOD_PUT,
            Route::ARTICLE.'/'.$article->getId(),
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'body' => json_encode([
                    'name' => $faker->name,
                    'reference' => $faker->company,
                    'content' => $faker->text,
                    'draft' => $faker->boolean,
                ], JSON_THROW_ON_ERROR),
            ]
        );

        self::assertResponseStatusCodeSame(200);
        self::assertUriExist(Route::ARTICLE, $response);

        // should throw an exception if the article is not find
        $this->getRepository()->find($this->getUriIdentifier(Route::ARTICLE, $response));
    }

    /**
     * @test
     */
    public function invalidArticleShouldRenderAnError(): void
    {
        $article = $this->buildArticle();
        $faker = Factory::create();
        $response = static::$client->request(
            Request::METHOD_PUT,
            Route::ARTICLE.'/'.$article->getId(),
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'body' => json_encode([
                    'reference' => $faker->company,
                    'content' => $faker->text,
                    'draft' => $faker->boolean,
                ], JSON_THROW_ON_ERROR),
            ]
        );

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

    private function buildArticle(): Article
    {
        // initialize an existing Article
        $command = (new AddArticleBuilder())->build();
        $article = Article::createWith($command);
        $this->getRepository()->save($article);

        return $article;
    }
}
