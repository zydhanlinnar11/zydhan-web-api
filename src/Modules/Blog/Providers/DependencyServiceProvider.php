<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Database\factories\CommentFactory;
use Modules\Blog\Database\factories\PostFactory;
use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Factories\PostFactoryInterface;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Infrastructure\Queries\QueryBuilderAdminEditPostQuery;
use Modules\Blog\Infrastructure\Queries\QueryBuilderAdminPostsQuery;
use Modules\Blog\Infrastructure\Queries\QueryBuilderHomePostsQuery;
use Modules\Blog\Infrastructure\Queries\QueryBuilderPortfolioPostsQuery;
use Modules\Blog\Infrastructure\Queries\QueryBuilderPostCommentsQuery;
use Modules\Blog\Infrastructure\Repositories\QueryBuilderCommentRepository;
use Modules\Blog\Infrastructure\Repositories\QueryBuilderPostRepository;
use Modules\Blog\Transformers\AdminEditPost\AdminEditPostQueryInterface;
use Modules\Blog\Transformers\AdminPosts\AdminPostsQueryInterface;
use Modules\Blog\Transformers\HomePosts\HomePostsQueryInterface;
use Modules\Blog\Transformers\PortfolioPosts\PortfolioPostsQueryInterface;
use Modules\Blog\Transformers\PostComments\PostCommentsQueryInterface;

class DependencyServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostRepositoryInterface::class, QueryBuilderPostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, QueryBuilderCommentRepository::class);
        $this->app->bind(CommentFactoryInterface::class, CommentFactory::class);
        $this->app->bind(PostFactoryInterface::class, PostFactory::class);

        $this->app->bind(HomePostsQueryInterface::class, QueryBuilderHomePostsQuery::class);
        $this->app->bind(PostCommentsQueryInterface::class, QueryBuilderPostCommentsQuery::class);
        $this->app->bind(AdminPostsQueryInterface::class, QueryBuilderAdminPostsQuery::class);
        $this->app->bind(AdminEditPostQueryInterface::class, QueryBuilderAdminEditPostQuery::class);
        $this->app->bind(PortfolioPostsQueryInterface::class, QueryBuilderPortfolioPostsQuery::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
