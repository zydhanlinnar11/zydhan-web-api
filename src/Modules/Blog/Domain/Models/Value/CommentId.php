<?php

namespace Modules\Blog\Domain\Models\Value;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class CommentId
{
    private string $id;

    public function __construct(?string $id = null)
    {
        if (!$id) {
            $id = Uuid::uuid4()->toString();
        }

        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('comment_id_not_a_valid_uuid');
        }

        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function equals(CommentId $commentId): bool
    {
        return $commentId->toString() === $this->toString();
    }
}