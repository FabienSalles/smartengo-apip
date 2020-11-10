<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\CommandHandler\AddArticleHandler;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

class AddArticleHandlerTest extends ArticleHandlerTest
{
    use ValidatorTrait;

    private AddArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new AddArticleHandler(
            $this->getValidator(AddArticle::class),
            $this->repository
        );
    }

    /**
     * @test
     */
    public function aValidArticleShouldBeCorrectlySaved(): void
    {
        /** @var AddArticle $command */
        $command = $this->getBuilder()->build();

        $this->getHandler()($command);

        $article = $this->getRepository()->find($command->id);

        $this->assertCommonProperties($command, $article);
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $article->getCreatedAt()->format(DATE_ATOM)
        );
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
