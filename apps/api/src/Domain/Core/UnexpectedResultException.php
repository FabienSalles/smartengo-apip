<?php

namespace Smartengo\Domain\Core;

class UnexpectedResultException extends \Exception
{
    public function __construct(?\Throwable $previous, string $message = null)
    {
        if (null !== $previous) {
            parent::__construct($previous->getMessage(), 500, $previous);
        } else {
            parent::__construct($message ?? 'Unexpected result!', 500);
        }
    }
}
