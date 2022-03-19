<?php

namespace Modules\Blog\Infrastructure\Queries;

use Illuminate\Support\Facades\DB;
use Modules\Blog\Transformers\ViewPost\ViewPostQueryInterface;
use Modules\Blog\Transformers\ViewPost\ViewPostResource;

class QueryBuilderViewPostQuery implements ViewPostQueryInterface
{
    public function execute(string $slug): ViewPostResource
    {
        $post = DB::table('posts')
                    ->select(['title', 'description', 'created_at', 'slug', 'markdown'])
                    ->get()[0];

        return new ViewPostResource(
            slug: $post->slug,
            title: $post->title,
            description: $post->description,
            markdown: $post->markdown,
            createdAt: $post->created_at
        );
    }
}