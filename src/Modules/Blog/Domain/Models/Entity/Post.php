<?php

namespace Modules\Blog\Domain\Models\Entity;

use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Value\PostVisibility\PostVisibility;

class Post
{
    public function __construct(
        private PostId $id,
        private UserId $userId,
        private string $title,
        private string $description,
        private string $markdown,
        private string $slug,
        private PostVisibility $visibility,
    ) { }

    public function getId(): PostId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getMarkdown(): string
    {
        return $this->markdown;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getVisibility(): PostVisibility
    {
        return $this->visibility;
    }
}