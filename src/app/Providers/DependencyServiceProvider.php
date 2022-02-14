<?php

namespace App\Providers;

use Domain\Auth\Services\GenerateHashServiceInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Auth\HashFacadeService;

class DependencyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GenerateHashServiceInterface::class, HashFacadeService::class);
    }
}
