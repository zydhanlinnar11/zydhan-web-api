<?php

namespace App\Auth\Services\RegisterUser;

class RegisterUserRequest
{
    public function __construct(
        public string $name,
        public string $email,
        public string $username,
        public string $password,
    ) { }
}