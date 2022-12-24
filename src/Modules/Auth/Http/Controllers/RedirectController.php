<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;
use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class RedirectController extends Controller
{
    use SocialiteConfig;

    /**
     * Redirect to OAuth2 Provider.
     * @return \Illuminate\Http\JsonResponse
     */
    public function redirect(SocialMedia $socialMedia)
    {
        $this->prepareConfig($socialMedia);

        $redirectUrl = Socialite::driver($socialMedia->getSocialiteName())
                    ->redirect()
                    ->getTargetUrl();
        
        return response()->json(['redirect_url' => $redirectUrl]);
    }
}
