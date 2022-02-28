<?php

namespace Modules\Blog\Domain\Models\Entity;

use DateTime;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Value\CommentId;
use Modules\Blog\Domain\Models\Value\PostId;

class Comment
{
    public function __construct(
        private CommentId $id,
        private UserId $userId,
        private PostId $postId,
        private string $comment,
        private DateTime $createdAt,
        private DateTime $updatedAt,
    ) { }

    public function getId(): CommentId
    {
        return $this->id;
    }

    public function getPostId(): PostId
    {
        return $this->postId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function editComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}