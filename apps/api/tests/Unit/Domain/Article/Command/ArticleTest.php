<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use PHPUnit\Framework\TestCase;
use Smartengo\Domain\Article\Entity\Tag;
use Smartengo\Domain\Article\Repository\TagRepository;
use Smartengo\Domain\Core\Identifier;
use Smartengo\Infrastructure\Repository\Article\InMemoryTagRepository;
use Smartengo\Tests\Unit\Core\Validator\ValidatorTrait;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\AddTagBuilder;
use Smartengo\Tests\Unit\Domain\Article\Command\Builder\ArticleBuilder;

abstract class ArticleTest extends TestCase
{
    use ValidatorTrait;

    private TagRepository $tagRepository;

    public function setUp(): void
    {
        $this->tagRepository = new InMemoryTagRepository();
    }

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
    public function articleWithNonExistingTagsShouldNotBeValid(): void
    {
        $nonExistingTagId = Identifier::generate();
        $command = $this->getBuilder()
            ->withTags([$nonExistingTagId])
            ->build();

        $validator = $this->getValidator();
        $violationList = $validator->validate($command);

        self::assertCount(1, $violationList);
        self::assertSame(
            sprintf('The Tag %s does not exist', $nonExistingTagId),
            $this->findViolationsByPropertyName($violationList, 'tags[0]')[0]->getMessage()
        );
    }

    /**
     * @test
     */
    public function articleWithExistingTagsShouldBeValid(): void
    {
        $command = $this->getBuilder()
            ->withTags([
                $this->tagRepository->save(Tag::createWith((new AddTagBuilder)->build())),
                $this->tagRepository->save(Tag::createWith((new AddTagBuilder)->build())),
                $this->tagRepository->save(Tag::createWith((new AddTagBuilder)->build()))
            ])
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
