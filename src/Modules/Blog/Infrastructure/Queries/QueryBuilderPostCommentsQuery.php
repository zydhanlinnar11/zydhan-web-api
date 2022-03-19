<?php

namespace Modules\Blog\Infrastructure\Queries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Transformers\PostComments\PostCommentResource;
use Modules\Blog\Transformers\PostComments\PostCommentsQueryInterface;

class QueryBuilderPostCommentsQuery implements PostCommentsQueryInterface
{
    /**
     * @return PostCommentResource[]
     */
    public function execute(string $postId)
    {
        $comments = DB::table('comments', 'c')->select(['c.id', 'c.content', 'c.created_at', 'u.user_name', 'c.user_id'])
                ->leftJoinSub(
                    DB::table('users')->selectRaw('name AS user_name, id'),
                    'u', 'c.user_id', '=', 'u.id'
                )
                ->where('c.post_id', '=', $postId)
                ->orderByDesc('c.created_at')
                ->get();

        $arr = [];

        foreach($comments as $comment) {
            array_push($arr, new PostCommentResource(
                id: $comment->id,
                comment: $comment->content,
                createdAt: (new DateTime($comment->created_at))->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y'),
                user_name: $comment->user_name,
                user_id: $comment->user_id,
            ));
        }

        return $arr;
    }
}