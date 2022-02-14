<?php

namespace Domain\Auth\Exceptions;

use Exception;

class EmailAlreadyExistException extends Exception
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "email_already_exist";
        }

        parent::__construct($message, $code, $previous);
    }
}