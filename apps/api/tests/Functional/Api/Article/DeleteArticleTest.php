<?php

namespace Smartengo\Tests\Functional\Api\Article;

use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Tests\Functional\Api\Route;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Symfony\Component\HttpFoundation\Request;

class DeleteArticleTest extends ArticleTest
{
    /**
     * @test
     */
    public function deleteAnArticleSuccessfully(): void
    {
        // initialize an existing Article
        $command = (new AddArticleBuilder())->build();
        $article = Article::createWith($command);
        $this->getRepository()->save($article);

        $response = static::$client->request(Request::METHOD_DELETE, Route::ARTICLE.'/'.$command->id);

        self::assertResponseStatusCodeSame(204);
    }
}
