<?php

namespace Modules\Blog\Infrastructure\Queries;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Domain\Models\Value\PostVisibility;
use Modules\Blog\Transformers\PortfolioPosts\PortfolioPostResource;
use Modules\Blog\Transformers\PortfolioPosts\PortfolioPostsQueryInterface;

class QueryBuilderPortfolioPostsQuery implements PortfolioPostsQueryInterface
{
    /**
     * @return PortfolioPostResource[]
     */
    public function execute()
    {
        $posts = DB::table('posts')->select(['title', 'slug', 'created_at', 'description'])
                ->where('visibility', '=', PostVisibility::VISIBLE)
                ->orderByDesc('created_at')
                ->get();

        $arr = [];

        foreach($posts as $post) {
            array_push($arr, new PortfolioPostResource(
                title: $post->title,
                description: $post->description,
                slug: $post->slug,
                created_at: (new DateTime($post->created_at))->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('d/m/Y')
            ));
        }

        return $arr;
    }
}