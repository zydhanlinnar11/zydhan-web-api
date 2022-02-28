<?php

namespace Modules\Blog\Domain\Repositories;

use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Value\CommentId;
use Modules\Blog\Domain\Models\Value\PostId;

interface CommentRepositoryInterface
{
    public function findById(CommentId $commentId): ?Comment;

    /**
     * Get all comments by post.
     * @param \Modules\Blog\Domain\Models\Value\PostId $postId
     * @return \Modules\Blog\Domain\Models\Entity\Comment[]
     */
    public function findAllByPostId(PostId $postId);
    public function save(Comment $comment): bool;
    public function delete(Comment $comment): bool;
}