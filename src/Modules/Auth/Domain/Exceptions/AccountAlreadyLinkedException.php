<?php

namespace Modules\Auth\Domain\Exceptions;

class AccountAlreadyLinkedException extends AbstractDomainException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "account_already_linked";
        }

        parent::__construct($message, $code, $previous);
    }
}