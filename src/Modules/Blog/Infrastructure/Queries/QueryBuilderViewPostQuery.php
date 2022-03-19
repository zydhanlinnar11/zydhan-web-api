<?php

namespace Modules\Blog\Infrastructure\Queries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Transformers\ViewPost\ViewPostQueryInterface;
use Modules\Blog\Transformers\ViewPost\ViewPostResource;

class QueryBuilderViewPostQuery implements ViewPostQueryInterface
{
    public function execute(string $slug): ViewPostResource
    {
        $posts = DB::table('posts')
                    ->select(['title', 'description', 'created_at', 'slug', 'markdown'])
                    ->where('slug', '=', $slug)
                    ->get();

        if ($posts->count() === 0) {
            abort(404);
        }

        $post = $posts[0];

        return new ViewPostResource(
            slug: $post->slug,
            title: $post->title,
            description: $post->description,
            markdown: $post->markdown,
            createdAt: (new DateTime($post->created_at))->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y')
        );
    }
}