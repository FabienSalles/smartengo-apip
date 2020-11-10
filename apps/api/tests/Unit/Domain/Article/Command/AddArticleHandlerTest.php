<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Article\CommandHandler\AddArticleHandler;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\InvalidCommandException;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;

class AddArticleHandlerTest extends TestCase
{
    use ValidatorTrait;

    private AddArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp()
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
    public function anInvalidArticleShouldNotBeSaved(): void
    {
        $command = (new AddArticleBuilder())
            ->withName('')
            ->build();

        $this->expectException(InvalidCommandException::class);

        $this->handler->__invoke($command);
    }

    /**
     * @test
     */
    public function aValidArticleShouldBeCorrectlySaved(): void
    {
        $command = (new AddArticleBuilder())->build();

        $this->handler->__invoke($command);

        $article = $this->repository->find($command->id);

        self::assertInstanceOf(Article::class, $article);
        self::assertSame($command->id, $article->getId());
        self::assertSame($command->name, $article->getName());
        self::assertSame($command->reference, $article->getReference());
        self::assertSame($command->content, $article->getContent());
        self::assertSame($command->draft, $article->isDraft());
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $article->getCreatedAt()->format(DATE_ATOM)
        );
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $article->getUpdatedAt()->format(DATE_ATOM)
        );
    }
}
