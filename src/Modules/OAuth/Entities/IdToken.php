<?php

namespace Modules\OAuth\Entities;

use Firebase\JWT\JWT;
use League\OAuth2\Server\CryptKey;

class IdToken
{
    public function __construct(
        private CryptKey $privateKey,
        private string $issuer,
        private string $subject,
        private string $audience,
        private \DateTimeImmutable $expiration = new \DateTimeImmutable(),
        private \DateTimeImmutable $issuedAt = new \DateTimeImmutable(),
    )
    { }

    public function toJWT()
    {
        return JWT::encode(
            payload: $this->toArray(),
            key: $this->privateKey->getKeyContents(),
            alg: 'RS256'
        );
    }

    /**
     * @return array<string|int>
     */
    public function toArray(): array
    {
        $array = [
            'iss' => $this->issuer,
            'sub' => $this->subject,
            'aud' => $this->audience,
            'exp' => intval($this->expiration->format('U')),
            'iat' => intval($this->issuedAt->format('U')),
        ];

        return $array;
    }
}