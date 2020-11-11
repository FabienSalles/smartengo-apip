<?php

namespace Smartengo\Tests\Unit\Domain\Article\Query;

use PHPUnit\Framework\TestCase;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Query\Builder\GetOneArticleBuilder;

class GetOneArticleTest extends TestCase
{
    use ValidatorTrait;

    /**
     * @test
     */
    public function aQueryWithoutAnIdShouldBeInvalid(): void
    {
        $command = (new GetOneArticleBuilder())
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
    public function aQueryWithAnInvalidIdShouldBeInvalid(): void
    {
        $command = (new GetOneArticleBuilder())
            ->withId('test')
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
    public function aQueryWithAnIdShouldValidIfThisIdExist(): void
    {
        $command = (new GetOneArticleBuilder())->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }
}
