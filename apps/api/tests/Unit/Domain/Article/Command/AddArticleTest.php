<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Monolog\Test\TestCase;
use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;

class AddArticleTest extends TestCase
{
    use ValidatorTrait;

    /**
     * @test
     */
    public function completeArticleShouldBeValid(): void
    {
        $command = (new AddArticleBuilder())
            ->build();

        $validator = $this->getValidator(AddArticle::class);
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }

    /**
     * @test
     */
    public function articleShouldHaveAName(): void
    {
        $command = (new AddArticleBuilder())
            ->withName('')
            ->build();

        $validator = $this->getValidator(AddArticle::class);
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
        $command = (new AddArticleBuilder())
            ->withReference('')
            ->build();

        $validator = $this->getValidator(AddArticle::class);
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
        $command = (new AddArticleBuilder())
            ->withContent('')
            ->build();

        $validator = $this->getValidator(AddArticle::class);
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'content')[0]->getMessage()
        );
    }
}
