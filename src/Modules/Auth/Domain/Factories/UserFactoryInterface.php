<?php

namespace Modules\Auth\Domain\Factories;

use Modules\Auth\Domain\Models\Entity\User;

interface UserFactoryInterface
{
    public function createNewUser(
        string $name,
        string $email,
        string $username,
        string $password,
    ) : User;

    public function generateRandom() : User;
}
