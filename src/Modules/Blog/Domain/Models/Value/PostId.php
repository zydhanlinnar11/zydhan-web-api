<?php

namespace Modules\Blog\Domain\Models\Value;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class PostId
{
    private string $id;

    public function __construct(?string $id = null)
    {
        if (!$id) {
            $id = Uuid::uuid4()->toString();
        }

        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('post_id_not_a_valid_uuid');
        }

        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function equals(PostId $postId): bool
    {
        return $postId->toString() === $this->toString();
    }
}