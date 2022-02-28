<?php

namespace Modules\Blog\Database\factories;

use DateTime;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Value\CommentId;

class CommentFactory implements CommentFactoryInterface
{
    public function createNewComment(UserId $userId, PostId $postId, string $comment): Comment
    {
        $now = new DateTime();

        return new Comment(
            id: new CommentId(),
            userId: $userId,
            postId: $postId,
            comment: $comment,
            createdAt: $now,
            updatedAt: $now
        );
    }
}