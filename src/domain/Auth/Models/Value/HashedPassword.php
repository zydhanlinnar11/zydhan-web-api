<?php

namespace Domain\Auth\Models\Value;

use Illuminate\Support\Facades\Hash;

class HashedPassword
{
    private string $hashedPassword;

    public function __construct(string $password)
    {
        $this->hashedPassword = Hash::make($password);
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }
}