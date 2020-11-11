<?php

namespace Smartengo\Domain\Article\Command;

use Smartengo\Domain\Core\IdentifierAwareCommand;

class AddTag extends IdentifierAwareCommand
{
    public ?string $title = null;
}
