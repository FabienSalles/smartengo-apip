<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command\Builder;

use Faker\Factory;
use Smartengo\Domain\Article\Command\Article;
use Smartengo\Domain\Core\Builder;
use Smartengo\Domain\Core\Identifier;

abstract class ArticleBuilder implements Builder
{
    protected string $id;
    private string $name;
    private string $reference;
    private string $content;
    private bool $draft;

    public function __construct()
    {
        $faker = Factory::create();
        $this->id = Identifier::generate();
        $this->name = $faker->name;
        $this->reference = $faker->company;
        $this->content = $faker->text;
        $this->draft = $faker->boolean;
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function withReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function withContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isDraft(): self
    {
        $this->draft = true;

        return $this;
    }

    public function isNotDraft(): self
    {
        $this->draft = false;

        return $this;
    }

    protected function buildArticle(Article $article): Article
    {
        $article->id = $this->id;
        $article->name = $this->name;
        $article->reference = $this->reference;
        $article->content = $this->content;
        $article->draft = $this->draft;

        return $article;
    }
}
