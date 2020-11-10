<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command;

use Smartengo\Domain\Article\Command\AddArticle;
use Smartengo\Domain\Core\Builder;

class AddArticleBuilder implements Builder
{
    private $id;
    private string $name = 'one name';
    private string $reference = 'one reference';
    private string $content = 'one content';
    private bool $draft = true;

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

    public function build(): AddArticle
    {
        $command = new AddArticle();
        $command->id = $this->id;
        $command->name = $this->name;
        $command->reference = $this->reference;
        $command->content = $this->content;
        $command->draft = $this->draft;

        return $command;
    }
}
