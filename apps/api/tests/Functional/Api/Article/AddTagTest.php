<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Faker\Factory;
use Smartengo\Tests\Functional\Api\Route;
use Symfony\Component\HttpFoundation\Request;

class AddTagTest extends TagTest
{
    /**
     * @test
     */
    public function validTagShouldBeAdded(): void
    {
        $faker = Factory::create();
        $response = static::$client->request(Request::METHOD_POST, Route::TAG, [
            'headers' => ['content-type' => 'application/ld+json'],
            'body' => json_encode([
                'title' => $faker->title,
            ], JSON_THROW_ON_ERROR),
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertUriExist(Route::TAG, $response);

        // should throw an exception if the article is not find
        $this->getRepository()->get($this->getUriIdentifier(Route::TAG, $response));
    }

    /**
     * @test
     */
    public function invalidTagShouldRenderAnError(): void
    {
        $faker = Factory::create();
        $response = static::$client->request(Request::METHOD_POST, Route::TAG, [
            'headers' => ['content-type' => 'application/ld+json'],
            'body' => json_encode([
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
                        'propertyPath' => 'title',
                        'message' => 'This value should not be blank.',
                    ],
                ],
            ]
        );
    }
}
