<?php

namespace Modules\Blog\Infrastructure\Queries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Transformers\AdminPosts\AdminPostResource;
use Modules\Blog\Transformers\AdminPosts\AdminPostsQueryInterface;

class QueryBuilderAdminPostsQuery implements AdminPostsQueryInterface
{
    /**
     * @return AdminPostResource[]
     */
    public function execute()
    {
        $posts = DB::table('posts')->select(['title', 'id', 'created_at'])
                ->orderByDesc('created_at')
                ->get();

        $arr = [];

        foreach($posts as $post) {
            array_push($arr, new AdminPostResource(
                id: $post->id,
                title: $post->title,
                coverUrl: 'https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp',
                created_at: (new DateTime($post->created_at))->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y')
            ));
        }

        return $arr;
    }
}