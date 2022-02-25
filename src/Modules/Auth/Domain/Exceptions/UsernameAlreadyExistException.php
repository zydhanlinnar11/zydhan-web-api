<?php

namespace Modules\Auth\Domain\Exceptions;

class UsernameAlreadyExistException extends AbstractDomainException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "username_already_exist";
        }

        parent::__construct($message, $code, $previous);
    }
}