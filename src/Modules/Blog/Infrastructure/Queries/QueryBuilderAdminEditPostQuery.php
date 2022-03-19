<?php

namespace Modules\Blog\Infrastructure\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Blog\Transformers\AdminEditPost\AdminEditPostQueryInterface;
use Modules\Blog\Transformers\AdminEditPost\AdminEditPostResource;

class QueryBuilderAdminEditPostQuery implements AdminEditPostQueryInterface
{
    public function execute(string $id): AdminEditPostResource
    {
        $posts = DB::table('posts')
                    ->where('id', '=', $id)
                    ->select(['title', 'description', 'visibility', 'markdown', 'slug'])
                    ->get();

        if ($posts->count() === 0) {
            abort(404);
        }

        $post = $posts[0];

        return new AdminEditPostResource(
            title: $post->title,
            description: $post->description,
            visibility: $post->visibility,
            markdown: $post->markdown,
            slug: $post->slug,
        );
    }
}