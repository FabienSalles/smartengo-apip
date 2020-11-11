<?php


namespace Smartengo\Tests\Functional\Api\Article;


use Smartengo\Domain\Article\CommandHandler\AddArticleHandler;
use Smartengo\Tests\Functional\Api\Route;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Symfony\Component\HttpFoundation\Request;

class GetArticlesByTagsTest extends ArticleTest
{
    use TagTrait;
    /**
     * @test
     */
    public function aQueryWithoutExistingTagsShouldReturnEmptyResponse(): void
    {
        $tag = $this->createTag();
        $response = static::$client->request(
            Request::METHOD_GET,
            Route::ARTICLE.'?'.http_build_query(['tags' => [$tag->getTitle()]])
        );

        self::assertResponseStatusCodeSame(200);

        self::assertJsonContains(
            [
                'hydra:totalItems' => 0,
            ]
        );
    }

    /**
     * @test
     */
    public function aQueryWithATagMatchingAnExistingArticleShouldReturnSuccessfullyTheArticle(): void
    {
        $tag = $this->createTag();
        $this->createArticleWithTags([$tag->getId()]);

        $response = static::$client->request(
            Request::METHOD_GET,
            Route::ARTICLE.'?'.http_build_query(['tags' => [$tag->getTitle()]])
        );

        self::assertResponseStatusCodeSame(200);

        self::assertJsonContains(
            [
                'hydra:totalItems' => 1,
            ]
        );
    }

    private function createArticleWithTags(array $tags): void
    {
        self::$container->get(AddArticleHandler::class)((new AddArticleBuilder())->withTags($tags)->build());
    }
}
