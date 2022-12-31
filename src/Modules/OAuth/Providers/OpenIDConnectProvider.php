<?php

namespace Modules\OAuth\Providers;

use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\AuthCodeRepository;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\ScopeRepository;
use Laravel\Passport\PassportServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use Modules\OAuth\Grants\AuthCodeGrant;
use Modules\OAuth\ResponseTypes\BearerTokenResponse;

class OpenIDConnectProvider extends PassportServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected function buildAuthCodeGrant()
    {
        $authCodeGrant = new AuthCodeGrant(
            $this->app->make(AuthCodeRepository::class),
            $this->app->make(RefreshTokenRepository::class),
            new \DateInterval('PT10M'),
            new \DateInterval('PT10M'),
        );
        $authCodeGrant->setIssuer(config('app.frontend.url', 'https://zydhan.com'));

        return $authCodeGrant; 
    }

    /**
     * Make the authorization service instance.
     *
     * @return \League\OAuth2\Server\AuthorizationServer
     */
    public function makeAuthorizationServer()
    {
        return new AuthorizationServer(
            $this->app->make(ClientRepository::class),
            $this->app->make(AccessTokenRepository::class),
            $this->app->make(ScopeRepository::class),
            $this->makeCryptKey('private'),
            app('encrypter')->getKey(),
            new BearerTokenResponse()
        );
    }
}
