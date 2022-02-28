<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;
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
