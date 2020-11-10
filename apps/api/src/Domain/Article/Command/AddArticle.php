<?php

namespace Smartengo\Domain\Article\Command;

class AddArticle
{
    /** @var string */
    public $id;
    public string $name;
    public string $reference;
    public string $content;
    public bool $draft = true;
}
