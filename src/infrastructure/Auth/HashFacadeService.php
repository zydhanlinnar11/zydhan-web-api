<?php

namespace Infrastructure\Auth;

use Domain\Auth\Services\GenerateHashServiceInterface;
use Illuminate\Support\Facades\Hash;

class HashFacadeService implements GenerateHashServiceInterface
{
    public function generate(string $text): string
    {
        return Hash::make($text);
    }
}