<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialRequest;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialService;
use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use ValueError;

class SocialAuthController extends Controller
{
    public function __construct(
        public UserFactoryInterface $userFactory,
        public UserRepositoryInterface $userRepository,
    ) { }

    public function handleRedirect(SocialProvider $social_provider)
    {
        return Socialite::driver($social_provider->name())->redirect();
    }

    public function handleCallback(SocialProvider $social_provider)
    {
        $socialUser = Socialite::driver($social_provider->name())->user();

        $request = new LoginFromSocialRequest(
            socialId: $socialUser->getId(),
            name: $socialUser->getName(),
            email: $socialUser->getEmail(),
            socialProvider: $social_provider
        );
        try {
            $service = new LoginFromSocialService($this->userFactory, $this->userRepository);
            $service->execute($request);
        } catch(EmailAlreadyExistException $e) {
            return view('auth::social_error');
        }

        return view('auth::index');
    }
}
