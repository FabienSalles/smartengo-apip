<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;

class AddTagTest extends TestCase
{
    use ValidatorTrait;

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
    public function tagShouldHaveAValidId(): void
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
    public function tagShouldHaveATitle(): void
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
    public function completeTagShouldBeValid(): void
    {
        $command = (new AddTagBuilder())
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }
}
