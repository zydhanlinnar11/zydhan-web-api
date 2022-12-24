<?php

namespace Modules\Auth\Http\Controllers;

use App\Models\SocialMedia;

trait SocialiteConfig
{
    /**
     * Prepare Socialite configurations.
     */
    private function prepareConfig(SocialMedia $socialMedia)
    {
        $prefix = sprintf('services.%s', $socialMedia->getSocialiteName());
        $frontendUrl = config('app.frontend.url');
        $redirectUri = sprintf('%s/auth/%s/callback', $frontendUrl, $socialMedia->getId());
        config(["$prefix.client_id" => $socialMedia->getClientId()]);
        config(["$prefix.client_secret" => $socialMedia->getClientSecret()]);
        config(["$prefix.redirect" => $redirectUri]);
    }
}
