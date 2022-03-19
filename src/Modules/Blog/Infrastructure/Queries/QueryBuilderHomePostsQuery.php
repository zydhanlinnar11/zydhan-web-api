<?php

namespace Modules\Blog\Infrastructure\Queries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Transformers\HomePosts\HomePostResource;
use Modules\Blog\Transformers\HomePosts\HomePostsQueryInterface;

class QueryBuilderHomePostsQuery implements HomePostsQueryInterface
{
    /**
     * @return HomePostResource[]
     */
    public function execute()
    {
        $posts = DB::table('posts')->select(['title', 'slug', 'created_at'])
                ->where('visibility', '=', PostVisibility::VISIBLE)
                ->orderByDesc('created_at')
                ->get();

        $arr = [];

        foreach($posts as $post) {
            array_push($arr, new HomePostResource(
                title: $post->title,
                coverUrl: 'https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp',
                slug: $post->slug,
                created_at: (new DateTime($post->created_at))->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y')
            ));
        }

        return $arr;
    }
}