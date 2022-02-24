<?php

namespace Modules\Auth\App\Exceptions;

class UserNotFoundException extends AbstractApplicationServiceException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "user_not_found";
        }

        parent::__construct($message, $code, $previous);
    }
}