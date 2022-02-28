<?php

namespace Modules\Blog\Infrastructure\Repositories;

use DateTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Models\Entity\Post;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;

class QueryBuilderPostRepository implements PostRepositoryInterface
{
    private Builder $table;

    public function __construct()
    {
        $this->table = DB::table('posts');
    }

    public function findById(PostId $postId): ?Post
    {
        $result = $this->table
                ->where('id', '=', $postId->toString())
                ->first();

        if(!$result) {
            return null;
        }

        return $this->mapResultToDomainModel($result);
    }

    public function findBySlug(string $slug): ?Post
    {
        $result = $this->table->where('slug', '=', $slug)->first();

        if(!$result) {
            return null;
        }

        return $this->mapResultToDomainModel($result);
    }

    /**
     * Get all posts by visibilities.
     * @param \Modules\Blog\Domain\Models\Value\PostVisibility[] $visibilities
     * @return \Modules\Blog\Domain\Models\Entity\Post[]
     */
    public function findByVisibilities($visibilities)
    {
        $results = $this->table;

        foreach ($visibilities as $visibility) {
            $results = $results->orWhere('visibility', '=', $visibility);
        }

        $results = $results->get();
        if(!$results) {
            return [];
        }

        $arr = [];

        foreach($results as $result) {
            array_push($arr, $this->mapResultToDomainModel($result));
        }
        return $arr;
    }

    public function save(Post $post): Post
    {
        $this->table->updateOrInsert($this->toArray($post));

        return $post;
    }

    private function toArray(Post $post): array
    {
        return [
            'id' => $post->getId()->toString(),
            'user_id' => $post->getUserId()->getId(),
            'title' => $post->getTitle(),
            'description' => $post->getDescription(),
            'markdown' => $post->getMarkdown(),
            'slug' => $post->getSlug(),
            'visibility' => $post->getVisibility(),
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt()
        ];
    }

    private function mapResultToDomainModel(object $result): Post
    {
        return new Post(
            id: new PostId($result->id),
            userId: new UserId($result->user_id),
            title: $result->title,
            description: $result->description,
            markdown: $result->markdown,
            visibility: PostVisibility::from($result->visibility),
            createdAt: new DateTime($result->created_at),
            updatedAt: new DateTime($result->updated_at),
        );
    }
}