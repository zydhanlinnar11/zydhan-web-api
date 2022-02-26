<?php

namespace Modules\Auth\Domain\Models\Value;

class SocialId
{
    public function __construct(
        private string $id,
        private SocialProvider $provider,
    ) { }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSocialProvider(): SocialProvider
    {
        return $this->provider;
    }

    public function equals(UserId $userId): bool
    {
        return $this->getId() === $userId->getId();
    }
}
