<?php

namespace Infrastructure\Auth;

use Domain\Auth\Services\HashServiceInterface;
use Illuminate\Support\Facades\Hash;

class HashFacadeService implements HashServiceInterface
{
    public function generate(string $text): string
    {
        return Hash::make($text);
    }
}