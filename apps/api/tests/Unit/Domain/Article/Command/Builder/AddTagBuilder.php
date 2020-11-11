<?php

namespace Smartengo\Tests\Unit\Domain\Article\Command\Builder;

use Faker\Factory;
use Smartengo\Domain\Article\Command\AddTag;
use Smartengo\Domain\Core\Builder;
use Smartengo\Domain\Core\Identifier;

class AddTagBuilder implements Builder
{
    private string $id;
    private string $title;

    public function __construct()
    {
        $faker = Factory::create();
        $this->id = Identifier::generate();
        $this->title = $faker->title;
    }

    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function build(): AddTag
    {
        $command = new AddTag();
        $command->id = $this->id;
        $command->title = $this->title;

        return $command;
    }
}
