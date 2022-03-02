<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\App\Services\LinkSocialAccount\LinkSocialAccountRequest;
use Modules\Auth\App\Services\LinkSocialAccount\LinkSocialAccountService;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialRequest;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialService;
use Modules\Auth\Domain\Exceptions\EmailAlreadyExistException;
use Modules\Auth\Domain\Factories\UserFactoryInterface;
use Modules\Auth\Domain\Models\Value\SocialProvider;
use Modules\Auth\Domain\Repositories\UserRepositoryInterface;
use Modules\Auth\Facade\Auth;

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

    public function handleCallback(Request $request, SocialProvider $social_provider)
    {
        $authenticatedUser = Auth::user($request);
        $socialUser = Socialite::driver($social_provider->name())->user();

        if ($authenticatedUser) {
            $linkSocialAccountRequest = new LinkSocialAccountRequest(
                user: $authenticatedUser,
                socialId: $socialUser->getId(),
                socialProvider: $social_provider
            );

            $service = new LinkSocialAccountService($this->userRepository);
            $service->execute($linkSocialAccountRequest);
            return view('auth::index');
        }

        try {
            $loginFromSocialRequest = new LoginFromSocialRequest(
                socialId: $socialUser->getId(),
                name: $socialUser->getName(),
                email: $socialUser->getEmail(),
                socialProvider: $social_provider
            );
            $service = new LoginFromSocialService($this->userFactory, $this->userRepository);
            $service->execute($loginFromSocialRequest);
        } catch(EmailAlreadyExistException $e) {
            return view('auth::social_error');
        }

        return view('auth::index');
    }
}
