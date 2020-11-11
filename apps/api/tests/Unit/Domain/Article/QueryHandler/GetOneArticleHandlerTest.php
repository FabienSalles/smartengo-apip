<?php

namespace Smartengo\Tests\Unit\Domain\Article\QueryHandler;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Entity\Article;
use Smartengo\Domain\Article\Query\GetOneArticle;
use Smartengo\Domain\Article\QueryHandler\GetOneArticleHandler;
use Smartengo\Domain\Article\Repository\ArticleRepository;
use Smartengo\Domain\Core\Identifier;
use Smartengo\Domain\Core\InvalidQueryException;
use Smartengo\Domain\Core\NotFoundException;
use Smartengo\Infrastructure\Repository\Article\InMemoryArticleRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddArticleBuilder;
use Smartengo\Tests\Unit\Domain\Article\Query\Builder\GetOneArticleBuilder;

class GetOneArticleHandlerTest extends TestCase
{
    use ValidatorTrait;

    private ArticleRepository $repository;

    private GetOneArticleHandler $handler;

    public function setUp(): void
    {
        $this->repository = new InMemoryArticleRepository();
        $this->handler = new GetOneArticleHandler(
            $this->getValidator(GetOneArticle::class),
            $this->repository
        );
    }

    /**
     * @test
     */
    public function anInvalidQueryShouldNotThrowAnInvalidQueryException(): void
    {
        $command = (new GetOneArticleBuilder())
            ->withId('')
            ->build();

        $this->expectException(InvalidQueryException::class);

        $this->handler->__invoke($command);
    }

    /**
     * @test
     */
    public function aQueryWithANonExistingIdShouldThrowANotFoundException(): void
    {
        $command = (new GetOneArticleBuilder())
            ->withId(Identifier::generate())
            ->build();

        $this->expectException(NotFoundException::class);

        $this->handler->__invoke($command);
    }

    public function aValidQueryShouldReturnAnArticle(): void
    {
        $existingArticle = (new AddArticleBuilder())->build();
        $this->repository->save(Article::createWith($existingArticle));

        $command = (new GetOneArticleBuilder($existingArticle->id))
            ->build();

        $article = $this->handler->__invoke($command);

        self::assertSame($command->id, $article->getId());
    }
}
