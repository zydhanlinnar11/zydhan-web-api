<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialRequest;
use Modules\Auth\App\Services\LoginFromSocial\LoginFromSocialService;
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

    public function handleRedirect(string $provider)
    {
        try {
            SocialProvider::from($provider);
            return Socialite::driver($provider)->redirect();
        } catch(ValueError $e) {
            abort(404);
        }
    }

    public function handleCallback(string $provider)
    {
        try {
            $socialProvider = SocialProvider::from($provider);
            $socialUser = Socialite::driver($provider)->user();

            $request = new LoginFromSocialRequest(
                socialId: $socialUser->getId(),
                name: $socialUser->getName(),
                email: $socialUser->getEmail(),
                socialProvider: $socialProvider
            );
            $service = new LoginFromSocialService($this->userFactory, $this->userRepository);
            $service->execute($request);

            return view('auth::index');
        } catch(ValueError $e) {
            abort(404);
        }
    }
}
