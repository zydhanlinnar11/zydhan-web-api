<?php

namespace Modules\Auth\App\Services\LinkSocialAccount;

use Modules\Auth\Domain\Models\Entity\User;
use Modules\Auth\Domain\Models\Value\SocialProvider;

class LinkSocialAccountRequest
{
    public function __construct(
        public User $user,
        public string $socialId,
        public SocialProvider $socialProvider
    ) { }
}