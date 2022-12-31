<?php

namespace Modules\OAuth\Providers;

use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\Grant\AuthCodeGrant;

class OpenIDConnectProvider extends PassportServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function buildAuthCodeGrant()
    {
        return new AuthCodeGrant(
            $this->app->make(Bridge\AuthCodeRepository::class),
            $this->app->make(Bridge\RefreshTokenRepository::class),
            new \DateInterval('PT10M')
        );
    }
}
