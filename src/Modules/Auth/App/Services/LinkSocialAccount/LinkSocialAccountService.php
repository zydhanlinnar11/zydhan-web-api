<?php

namespace Modules\Auth\App\Services\LinkSocialAccount;

use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class LinkSocialAccountService
{
    public function __construct(
        public UserRepositoryInterface $userRepository
    ) { }

    public function execute(LinkSocialAccountRequest $request)
    {
        $user = $request->user;
        $socialId = $request->socialId;
        $socialProvider = $request->socialProvider;
        if ($socialProvider === SocialProvider::GOOGLE) {
            $user->linkGoogleAccount($socialId);
        } else {
            $user->linkGithubAccount($socialId);
        }
        $this->userRepository->save($user);
    }
}