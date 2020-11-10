<?php

namespace Smartengo\Domain\Article\Command;

use Smartengo\Domain\Core\IdentifierAwareCommand;

class Article extends IdentifierAwareCommand
{
    public string $name;
    public string $reference;
    public string $content;
    public bool $draft = true;
}
