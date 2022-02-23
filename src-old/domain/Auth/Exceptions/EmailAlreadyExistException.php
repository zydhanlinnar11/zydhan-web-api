<?php

namespace Domain\Auth\Exceptions;

class EmailAlreadyExistException extends AbstractDomainException
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