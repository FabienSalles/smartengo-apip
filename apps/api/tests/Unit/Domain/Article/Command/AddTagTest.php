<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;

class AddTagTest extends TestCase
{
    use ValidatorTrait;

    private TagRepository $repository;

    public function setUp(): void
    {
        $this->repository = new InMemoryTagRepository();
    }

    /**
     * @test
     */
    public function tagShouldHaveAnId(): void
    {
        $command = (new AddTagBuilder())
            ->withId('')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'id')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function aTagShouldHaveAValidId(): void
    {
        $command = (new AddTagBuilder())
            ->withId('invalid')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This is not a valid UUID.',
            $this->findViolationsByPropertyName($violationList, 'id')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function aTagShouldHaveATitle(): void
    {
        $command = (new AddTagBuilder())
            ->withTitle('')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'title')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function aTagShouldHaveAUniqueTitle(): void
    {
        $command = (new AddTagBuilder())
            ->build();
        $this->repository->save(Tag::createWith($command));

        $command = (new AddTagBuilder())
            ->withTitle($command->title)
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            sprintf('The title %s of the tag is already used', $command->title),
            $this->findViolationsByPropertyName($violationList, 'title')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function completeTagShouldBeValid(): void
    {
        $command = (new AddTagBuilder())
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }
}
