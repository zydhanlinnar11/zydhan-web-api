<?php

namespace Modules\Auth\App\Services\RegisterUser;

class RegisterUserRequest
{
    const validationRule = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
        'password_confirmation' => 'required',
    ];

    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) { }
}