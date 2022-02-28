<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Database\factories\CommentFactory;
use Modules\Blog\Domain\Factories\CommentFactoryInterface;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
use Modules\Blog\Infrastructure\Repositories\QueryBuilderCommentRepository;
use Modules\Blog\Infrastructure\Repositories\QueryBuilderPostRepository;

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
