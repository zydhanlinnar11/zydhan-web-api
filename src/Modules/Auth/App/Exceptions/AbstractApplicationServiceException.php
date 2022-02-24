<?php

namespace Modules\Auth\App\Exceptions;

use Exception;

abstract class AbstractApplicationServiceException extends Exception
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