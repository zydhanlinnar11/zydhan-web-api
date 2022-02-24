<?php

namespace Modules\Auth\App\Exceptions;

class WrongPasswordException extends AbstractApplicationServiceException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "wrong_password";
        }

        parent::__construct($message, $code, $previous);
    }
}