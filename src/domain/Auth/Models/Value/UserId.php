<?php

namespace Domain\Auth\Models\Value;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UserId
{
    private string $id;

    public function __construct(string $id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('user_id_is_not_valid_uuid');
        }

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function equals(UserId $userId): bool
    {
        return $this->getId() === $userId->getId();
    }
}
