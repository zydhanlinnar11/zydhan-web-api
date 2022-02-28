<?php

namespace Modules\Blog\Domain\Factories;

use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostVisibility;

interface PostFactoryInterface
{
    public function createNewPost(UserId $userId, string $title, string $description, string $markdown, PostVisibility $visibility): Post;
}