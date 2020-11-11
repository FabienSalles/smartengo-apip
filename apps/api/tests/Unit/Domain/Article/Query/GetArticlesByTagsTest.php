<?php

namespace Smartengo\Tests\Unit\Domain\Article\Query;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Query\GetArticlesByTags;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\TagTrait;

class GetArticlesByTagsTest extends TestCase
{
    use ValidatorTrait;
    use TagTrait;

    /**
     * @test
     */
    public function anEmptyQueryShouldBeInvalid(): void
    {
        $command = new GetArticlesByTags();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            'This value should not be blank.',
            $this->findViolationsByPropertyName($violationList, 'tags')[0]->getMessage()
        );
    }
}
