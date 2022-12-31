<?php

namespace Modules\OAuth\ResponseTypes;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse as LeagueBearerTokenResponse;
use Modules\OAuth\Entities\IdToken;

final class BearerTokenResponse extends LeagueBearerTokenResponse
{
    private ?IdToken $idToken = NULL;

    public function getIdToken(): ?IdToken
    {
        return $this->idToken;
    }

    public function setIdToken(IdToken $idToken)
    {
        $this->idToken = $idToken;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtraParams(AccessTokenEntityInterface $accessToken)
    {
        $params = [];

        if ($this->idToken) {
            $params['id_token'] = $this->idToken->toJWT();
        }

        return $params;
    }
}