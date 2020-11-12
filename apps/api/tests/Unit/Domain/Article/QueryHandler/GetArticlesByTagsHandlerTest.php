<?php

namespace Smartengo\Tests\Unit\Domain\Article\QueryHandler;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\CommandHandler\AddArticleHandler;
use Smartengo\Domain\Article\Query\GetArticlesByTags;
use Smartengo\Domain\Article\QueryHandler\GetArticlesByTagsHandler;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\InvalidQueryException;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\TagTrait;

class GetArticlesByTagsHandlerTest extends TestCase
{
    use ValidatorTrait;
    use TagTrait;

    private ArticleRepository $repository;

    private GetArticlesByTagsHandler $handler;

    private AddArticleHandler $addArticleHandler;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new GetArticlesByTagsHandler(
            $this->getValidator(),
            $this->repository
        );
        $this->addArticleHandler = new AddArticleHandler(
            $this->getValidator(),
            $this->repository,
            InMemoryTagRepository::getInstance()
        );
    }

    /**
     * @test
     */
    public function anInvalidQueryShouldNotThrowAnInvalidQueryException(): void
    {
        $command = new GetArticlesByTags();

        $this->expectException(InvalidQueryException::class);

        $this->handler->__invoke($command);
    }

    /**
     * @test
     */
    public function anExistingArticleShouldBeReturnByHisTag(): void
    {
        $tag = $this->createTag();

        $this->createArticleWithTags([$tag->getId()]);

        $command = new GetArticlesByTags([$tag->getTitle()]);

        $articles = $this->handler->__invoke($command);

        self::assertCount(1, $articles);
    }

    /**
     * @test
     */
    public function anExistingTagWithTwoArticleShouldReturnTowArticles(): void
    {
        $tag = $this->createTag();

        $this->createArticleWithTags([$tag->getId()]);
        $this->createArticleWithTags([$tag->getId()]);

        $command = new GetArticlesByTags([$tag->getTitle()]);

        $articles = $this->handler->__invoke($command);

        self::assertCount(2, $articles);
    }

    /**
     * @test
     */
    public function multipleTagsShouldReturnCorrespondingArticles(): void
    {
        $tag = $this->createTag();
        $tag2 = $this->createTag();
        $tag3 = $this->createTag();
        $this->createArticleWithTags([$tag->getId()]);
        $this->createArticleWithTags([$tag2->getId()]);
        $this->createArticleWithTags([$tag3->getId()]);

        $command = new GetArticlesByTags([$tag->getTitle(), $tag2->getTitle(), $tag3->getTitle()]);

        $articles = $this->handler->__invoke($command);

        self::assertCount(3, $articles);
    }

    private function createArticleWithTags(array $tags): void
    {
        $this->addArticleHandler->__invoke((new AddArticleBuilder())->withTags($tags)->build());
    }
}
