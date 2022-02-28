<?php

namespace Modules\Blog\Domain\Repositories;

use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Value\CommentId;
use Modules\Blog\Domain\Models\Value\PostId;

interface CommentRepositoryInterface
{
    public function findById(CommentId $commentId): ?Comment;
    public function findAllByPostId(PostId $postId): ?Comment;
    public function save(Comment $comment): bool;
}