<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Command\DeleteArticle;
use Smartengo\Domain\Article\CommandHandler\DeleteArticleHandler;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\Identifier;
use Smartengo\Domain\Core\NotFoundException;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;

class DeleteArticleHandlerTest extends TestCase
{
    use ValidatorTrait;

    private DeleteArticleHandler $handler;

    private ArticleRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new DeleteArticleHandler(
            $this->getValidator(),
            $this->repository,
            InMemoryTagRepository::getInstance()
        );
    }

    /**
     * @test
     */
    public function aDeletionForANotExistentArticleShouldThrowAnNotFoundException(): void
    {
        $comamnd = new DeleteArticle();
        $comamnd->id = Identifier::generate();

        $this->expectException(NotFoundException::class);

        $this->handler->__invoke($comamnd);
    }

    /**
     * @test
     */
    public function aDeletionForAExistingArticleShouldWorks(): void
    {
        // initialize an existing Article
        $existingArticle = (new AddArticleBuilder())->build();
        $this->repository->save(Article::createWith($existingArticle));

        $command = new DeleteArticle();
        $command->id = $existingArticle->id;
        $articleNumber = count($this->repository->getAll());

        $this->handler->__invoke($command);

        self::assertCount($articleNumber - 1, $this->repository->getAll());
    }
}
