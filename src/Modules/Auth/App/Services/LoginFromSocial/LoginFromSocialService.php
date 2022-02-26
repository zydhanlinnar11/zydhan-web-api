<?php

namespace Modules\Auth\App\Services\LoginFromSocial;

use Illuminate\Support\Facades\Auth;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Value\SocialId;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;

class LoginFromSocialService
{
    public function __construct(
        public UserFactoryInterface $userFactory,
        public UserRepositoryInterface $userRepository,
    ) { }

    public function execute(LoginFromSocialRequest $request)
    {
        $socialId = new SocialId($request->socialId, $request->socialProvider);
        $user = $this->userRepository->findBySocialId($socialId);

        if (!$user) {
            $user = $this->userFactory->createNewUserFromSocial(
                name: $request->name,
                email: $request->email,
                socialProvider: $request->socialProvider,
                socialId: $request->socialId
            );

            $this->userRepository->save($user);
        }

        Auth::login($user);
    }
}