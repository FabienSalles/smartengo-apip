<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\CommandHandler;
use Smartengo\Domain\Core\InvalidCommandException;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

abstract class ArticleHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function anInvalidArticleShouldNotBeSaved(): void
    {
        $command = $this->getBuilder()
            ->withName('')
            ->build();

        $this->expectException(InvalidCommandException::class);

        $this->getHandler()($command);
    }

    protected function assertCommonProperties(\Smartengo\Domain\Article\Command\Article $command, Article $article): void
    {
        self::assertSame($command->id, $article->getId());
        self::assertSame($command->name, $article->getName());
        self::assertSame($command->reference, $article->getReference());
        self::assertSame($command->content, $article->getContent());
        self::assertSame($command->draft, $article->isDraft());
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $article->getUpdatedAt()->format(DATE_ATOM)
        );
    }

    abstract protected function getBuilder(): ArticleBuilder;

    abstract protected function getHandler(): CommandHandler;

    abstract protected function getRepository(): ArticleRepository;
}
