<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Command\DeleteArticle;
use Smartengo\Domain\Core\Identifier;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;

class DeleteArticleTest extends TestCase
{
    use ValidatorTrait;

    /**
     * @test
     */
    public function aDeletionWithAnInvalidIdShouldBeInvalid(): void
    {
        $command = new DeleteArticle();
        $command->id = 'invalid';

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This is not a valid UUID.',
            $this->findViolationsByPropertyName($violationList, 'id')[0]->getMessage()
        );
    }

    public function aDeletionWithAValidIdShouldBeValid(): void
    {
        $command = new DeleteArticle();
        $command->id = Identifier::generate();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(0, $violationList);
    }
}
