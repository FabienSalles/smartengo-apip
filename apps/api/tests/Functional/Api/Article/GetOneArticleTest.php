<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Core\Identifier;
use Smartengo\Tests\Functional\Api\Route;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Symfony\Component\HttpFoundation\Request;

class GetOneArticleTest extends ArticleTest
{
    /**
     * @test
     */
    public function aQueryWithAnExistingIdShouldReturnAnArticle(): void
    {
        $command = (new AddArticleBuilder())->build();
        $this->getRepository()->save(Article::createWith($command));

        $response = static::$client->request(Request::METHOD_GET, Route::ARTICLE.'/'.$command->id);

        self::assertResponseStatusCodeSame(200);

        self::assertJsonContains(
            [
                '@context' => '/contexts/Article',
                '@id' => '/'.Route::ARTICLE.'/'.$command->id,
                '@type' => 'Article',
                'id' => $command->id,
                'name' => $command->name,
                'reference' => $command->reference,
                'content' => $command->content,
                'draft' => $command->draft,
            ]
        );
    }

    /**
     * @test
     */
    public function aQueryWithAnNonExistingIdShouldReturnAn404(): void
    {
        $response = static::$client->request(Request::METHOD_GET, Route::ARTICLE.'/'.Identifier::generate());

        self::assertResponseStatusCodeSame(404);
    }
}
