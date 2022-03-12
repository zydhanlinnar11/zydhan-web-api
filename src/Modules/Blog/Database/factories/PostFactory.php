<?php

namespace Modules\Blog\Database\factories;

use DateTime;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostId;

class PostFactory implements PostFactoryInterface
{
    public function createNewPost(UserId $userId, string $title, string $description, string $markdown, PostVisibility $visibility): Post
    {
        $now = new DateTime();

        return new Post(
            id: new PostId(),
            userId: $userId,
            title: $title,
            description: $description,
            markdown: $markdown,
            visibility: $visibility,
            createdAt: $now,
            updatedAt: $now
        );
    }
}