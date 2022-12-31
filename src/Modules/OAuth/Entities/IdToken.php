<?php

namespace Modules\OAuth\Entities;

use Firebase\JWT\JWT;

class IdToken
{
    public function __construct(
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
            key: config('app.key'),
            alg: 'HS256'
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