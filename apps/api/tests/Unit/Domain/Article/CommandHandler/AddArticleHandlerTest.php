<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\CommandHandler\AddArticleHandler;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\TagTrait;

class AddArticleHandlerTest extends ArticleHandlerTest
{
    use ValidatorTrait;
    use TagTrait;

    private AddArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new AddArticleHandler(
            $this->getValidator(),
            $this->repository,
            $this->tagRepository
        );
    }

    /**
     * @test
     */
    public function aValidArticleShouldBeCorrectlyAdded(): void
    {
        /** @var AddArticle $command */
        $command = $this->getBuilder()->build();

        $this->getHandler()($command);

        $article = $this->getRepository()->get($command->id);

        $this->assertCommonProperties($command, $article);
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $article->getCreatedAt()->format(DATE_ATOM)
        );
    }

    /**
     * @test
     */
    public function aValidArticleWithExistingTagShouldBeCorrectlyAdded(): void
    {
        /** @var AddArticle $command */
        $command = $this->getBuilder()
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

    protected function getBuilder(): ArticleBuilder
    {
        return new AddArticleBuilder();
    }

    protected function getHandler(): AddArticleHandler
    {
        return $this->handler;
    }

    protected function getRepository(): InMemoryArticleRepository
    {
        return $this->repository;
    }
}
