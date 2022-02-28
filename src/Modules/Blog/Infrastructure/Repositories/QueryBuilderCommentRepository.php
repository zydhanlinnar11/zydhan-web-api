<?php

namespace Modules\Blog\Infrastructure\Repositories;

use DateTime;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Domain\Models\Value\UserId;
use Modules\Blog\Domain\Models\Entity\Comment;
use Modules\Blog\Domain\Models\Value\CommentId;
use Modules\Blog\Domain\Models\Value\PostId;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;

class QueryBuilderCommentRepository implements CommentRepositoryInterface
{
    private Builder $table;

    public function __construct()
    {
        $this->table = DB::table('comments');
    }

    public function findById(CommentId $commentId): ?Comment
    {
        $result = $this->table->where('id', '=', $commentId->toString())->first();

        if(!$result) {
            return null;
        }

        return $this->mapResultToDomainModel($result);
    }

    public function save(Comment $comment): bool
    {
        try {
            $this->table->updateOrInsert($this->toArray($comment));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findAllByPostId(PostId $postId)
    {
        $results = $this->table->where('post_id', '=', $postId->toString())->get();

        if(!$results) {
            return [];
        }

        $arr = [];

        foreach($results as $result) {
            array_push($arr, $this->mapResultToDomainModel($result));
        }

        return $arr;
    }

    private function toArray(Comment $comment): array
    {
        return [
            'id' => $comment->getId()->toString(),
            'user_id' => $comment->getUserId()->getId(),
            'post_id' => $comment->getPostId()->toString(),
            'content' => $comment->getComment(),
            'created_at' => $comment->getCreatedAt(),
            'updated_at' => $comment->getUpdatedAt()
        ];
    }

    private function mapResultToDomainModel(object $result): Comment
    {
        return new Comment(
            id: new CommentId($result->id),
            userId: new UserId($result->user_id),
            postId: new PostId($result->post_id),
            comment: $result->content,
            createdAt: new DateTime($result->created_at),
            updatedAt: new DateTime($result->updated_at),
        );
    }
}