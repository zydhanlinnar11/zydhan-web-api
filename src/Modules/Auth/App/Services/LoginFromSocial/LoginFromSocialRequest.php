<?php

namespace Modules\Auth\App\Services\LoginFromSocial;

use Modules\Auth\Domain\Models\Value\SocialProvider;

class LoginFromSocialRequest
{
    public function __construct(
        public string $socialId,
        public string $name,
        public string $email,
        public SocialProvider $socialProvider,
        public ?string $avatar,
    ) { }
}