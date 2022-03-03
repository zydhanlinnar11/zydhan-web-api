<?php

namespace Modules\Auth\Domain\Exceptions;

class AccountNotLinkedException extends AbstractDomainException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        \Throwable|null $previous = null
    )
    {
        if (!$message) {
            $message = "account_not_linked";
        }

        parent::__construct($message, $code, $previous);
    }
}