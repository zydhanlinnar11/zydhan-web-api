<?php

namespace Modules\OAuth\Grants;

trait OpenIdConnectGrant
{
    private string $issuer;
    private \DateInterval $idTokenTTL;

    public function setIssuer(string $issuer)
    {
        $this->issuer = $issuer;
    }
}