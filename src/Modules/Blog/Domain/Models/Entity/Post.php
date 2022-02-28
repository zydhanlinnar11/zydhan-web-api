<?php

namespace Modules\Blog\Domain\Models\Entity;

use DateTime;
use Illuminate\Support\Str;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Value\PostVisibility;

class Post
{
    private string $slug;

    public function __construct(
        private PostId $id,
        private UserId $userId,
        private string $title,
        private string $description,
        private string $markdown,
        private PostVisibility $visibility,
        private DateTime $createdAt,
        private DateTime $updatedAt,
    ) { 
        $this->slug = Str::slug($title);
    }

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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function changeTitle(string $title): void
    {
        $this->title = $title;
    }

    public function changeDescription(string $description): void
    {
        $this->description = $description;
    }

    public function changeMarkdown(string $markdown): void
    {
        $this->markdown = $markdown;
    }

    public function changeVisibility(PostVisibility $visibility): void
    {
        $this->visibility = $visibility;
    }
}