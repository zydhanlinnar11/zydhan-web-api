<?php

namespace Modules\Apps\Domain\Models\Value;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class AppId
{
    private string $id;

    public function __construct(?string $id = NULL)
    {
        if (!$id) {
            $id = Uuid::uuid4()->toString();
        }

        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('app_id_is_not_valid_uuid');
        }

        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function equals(AppId $appId): bool
    {
        return $this->getId() === $appId->getId();
    }
}