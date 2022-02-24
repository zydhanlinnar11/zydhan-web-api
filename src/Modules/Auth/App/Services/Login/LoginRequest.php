<?php

namespace Modules\Auth\App\Services\Login;

class LoginRequest
{
    const validationRule = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    public function __construct(
        public string $email,
        public string $password,
    ) { }
}