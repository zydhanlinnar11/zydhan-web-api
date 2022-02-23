<?php

namespace Modules\Auth\Domain\Exceptions;

use Exception;

abstract class AbstractDomainException extends Exception
{
    public function __construct(
        string $message,
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}