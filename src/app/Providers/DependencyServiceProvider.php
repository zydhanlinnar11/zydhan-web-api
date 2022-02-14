<?php

namespace App\Providers;

use Domain\Auth\Repositories\UserRepositoryInterface;
use Domain\Auth\Services\HashServiceInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Auth\HashFacadeService;
use Infrastructure\Auth\Repositories\UserRepository;

class DependencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HashServiceInterface::class, HashFacadeService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
