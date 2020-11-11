<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

abstract class ArticleTest extends TestCase
{
    use ValidatorTrait;

    /**
     * @test
     */
    public function completeArticleShouldBeValid(): void
    {
        $command = $this->getBuilder()
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }

    /**
     * @test
     */
    public function articleShouldHaveAName(): void
    {
        $command = $this->getBuilder()
            ->withName('')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'name')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function articleShouldHaveAReference(): void
    {
        $command = $this->getBuilder()
            ->withReference('')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'reference')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function articleShouldHaveAContent(): void
    {
        $command = $this->getBuilder()
            ->withContent('')
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'content')[0]->getMessage()
        );
    }

    abstract protected function getBuilder(): ArticleBuilder;
}
