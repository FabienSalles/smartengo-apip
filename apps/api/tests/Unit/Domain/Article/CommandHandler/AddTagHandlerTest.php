<?php

namespace Smartengo\Tests\Unit\Domain\Article\CommandHandler;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\CommandHandler\AddTagHandler;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;

class AddTagHandlerTest extends TestCase
{
    use ValidatorTrait;

    private AddTagHandler $handler;

    private TagRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryTagRepository();
        $this->handler = new AddTagHandler(
            $this->getValidator(),
            $this->repository
        );
    }

    /**
     * @test
     */
    public function aValidTagShouldBeCorrectlyAdded(): void
    {
        $command = (new AddTagBuilder())->build();

        $this->handler->__invoke($command);

        $tag = $this->repository->get($command->id);

        self::assertSame($command->id, $tag->getId());
        self::assertSame($command->title, $tag->getTitle());
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $tag->getCreatedAt()->format(DATE_ATOM)
        );
        self::assertSame(
            (new \DateTimeImmutable())->format(DATE_ATOM),
            $tag->getUpdatedAt()->format(DATE_ATOM)
        );
    }
}
