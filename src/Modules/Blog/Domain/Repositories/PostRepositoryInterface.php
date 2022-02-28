<?php

namespace Modules\Blog\Domain\Repositories;

use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostId;

interface PostRepositoryInterface
{
    /**
     * Get all posts by visibilities.
     * @param \Modules\Blog\Domain\Models\Value\PostVisibility[] $visibilities
     * @return \Modules\Blog\Domain\Models\Entity\Post[]
     */
    public function findByVisibilities($visibilities);
    public function findById(PostId $postId): ?Post;
    public function findBySlug(string $slug): ?Post;
    public function save(Post $post): bool;
}