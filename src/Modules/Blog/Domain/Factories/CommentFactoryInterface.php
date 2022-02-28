<?php

namespace Modules\Blog\Domain\Factories;

use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Value\PostId;

interface CommentFactoryInterface
{
    public function createNewComment(UserId $userId, PostId $postId, string $comment): Comment;
}