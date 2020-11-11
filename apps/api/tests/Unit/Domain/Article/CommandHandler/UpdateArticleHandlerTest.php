<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\CommandHandler\UpdateArticleHandler;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\UpdateArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\TagTrait;

class UpdateArticleHandlerTest extends ArticleHandlerTest
{
    use ValidatorTrait;
    use TagTrait;

    private UpdateArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new UpdateArticleHandler(
            $this->getValidator(),
            $this->repository,
            $this->tagRepository
        );
    }

    /**
     * @test
     */
    public function aValidArticleShouldBeCorrectlyUpdated(): void
    {
        // initialize an existing Article
        $existingArticle = (new AddArticleBuilder())->build();
        $this->repository->save(Article::createWith($existingArticle));

        $command = $this->getBuilder()
            ->withId($existingArticle->id)
            ->build();

        $this->getHandler()($command);

        $article = $this->getRepository()->get($command->id);

        $this->assertCommonProperties($command, $article);
    }

    /**
     * @test
     */
    public function aValidArticleWithExistingTagShouldBeCorrectlyAdded(): void
    {
        // initialize an existing Article
        $existingArticle = (new AddArticleBuilder())->build();
        $this->repository->save(Article::createWith($existingArticle));

        $command = $this->getBuilder()
            ->withId($existingArticle->id)
            ->withTags([
                $this->createTag()->getId(),
                $this->createTag()->getId(),
                $this->createTag()->getId(),
            ])
            ->build();

        $this->getHandler()($command);

        $article = $this->getRepository()->get($command->id);

        self::assertCount(count($command->tags), $article->getTags());
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
