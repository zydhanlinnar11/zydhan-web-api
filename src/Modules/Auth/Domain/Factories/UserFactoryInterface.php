<?php

namespace Modules\Auth\Domain\Factories;

use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\SocialProvider;

interface UserFactoryInterface
{
    public function createNewUser(
        string $name,
        string $email,
        string $password,
    ) : User;

    public function createNewUserFromSocial(
        string $name,
        string $email,
        SocialProvider $socialProvider,
        string $socialId,
        ?string $avatar
    ) : User;

    public function generateRandom(bool $isAdmin = false) : User;
}
