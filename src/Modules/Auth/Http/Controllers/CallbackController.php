<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class CallbackController extends Controller
{
    use SocialiteConfig;

    /**
     * Retrieve user detail from OAuth2 Provider and log in / register user.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(SocialMedia $socialMedia)
    {
        $this->prepareConfig($socialMedia);

        $socialUser = Socialite::driver($socialMedia->getSocialiteName())
                        ->user();

        /** @var ?User $user */
        $user = $socialMedia->users()
                    ->wherePivot('identifier', $socialUser->getId())
                    ->first();

        /** @var \App\Models\User $authenticatedUser */
        $authenticatedUser = Auth::user('sanctum');
        if($authenticatedUser) {
            if($user !== NULL) {
                return abort(403, 'already_linked_to_another_user');
            }
            $socialMedia->linkUser($authenticatedUser->getId(), $socialUser->getId());

            return response()->json(['message' => 'Account linked', 200]);
        }

        if (!$user) {
            $userWithSameEmail = User::findByEmail($socialUser->getEmail());
            if($userWithSameEmail) {
                abort(401, 'user_with_same_email_exist');
            }

            $user = new User();
            $user->setName($socialUser->getName());
            $user->setEmail($socialUser->getEmail());
            $user->setPlainPassword(Str::random());
            $user->save();

            $socialMedia->users()
                ->attach(
                    id: $user->getId(),
                    attributes: ['identifier' => strval($socialUser->getId())]
                );
        }

        Auth::login($user);

        return response()->json(['message' => 'Authenticated'], 201);
    }
}
