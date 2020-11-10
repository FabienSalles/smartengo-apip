<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\UpdateArticle;
use Smartengo\Domain\Article\CommandHandler\UpdateArticleHandler;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\UpdateArticleBuilder;

class UpdateArticleHandlerTest extends ArticleHandlerTest
{
    use ValidatorTrait;

    private UpdateArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp()
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new UpdateArticleHandler(
            $this->getValidator(UpdateArticle::class),
            $this->repository
        );
    }

    /**
     * @test
     */
    public function aValidArticleShouldBeCorrectlySaved(): void
    {
        // initialize an existing Article
        $existingArticle = (new AddArticleBuilder())->build();
        $this->repository->save(Article::createWith($existingArticle));

        $command = $this->getBuilder()
            ->withId($existingArticle->id)
            ->build();

        $this->getHandler()($command);

        $article = $this->getRepository()->find($command->id);

        $this->assertCommonProperties($command, $article);
    }

    protected function getBuilder(): UpdateArticleBuilder
    {
        return new UpdateArticleBuilder();
    }

    protected function getHandler(): UpdateArticleHandler
    {
        return $this->handler;
    }

    protected function getRepository(): InMemoryArticleRepository
    {
        return $this->repository;
    }
}
