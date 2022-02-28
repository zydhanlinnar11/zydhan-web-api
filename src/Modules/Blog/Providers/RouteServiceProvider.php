<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use InvalidArgumentException;
use Modules\Blog\Domain\Models\Value\CommentId;
use Modules\Blog\Domain\Repositories\CommentRepositoryInterface;
use Modules\Blog\Domain\Repositories\PostRepositoryInterface;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Blog\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::bind('post', function (string $slug) {
            $post = $this->app->make(PostRepositoryInterface::class)->findBySlug($slug);
            if(!$post) {
                abort(404);
            }
            return $post;
        });

        Route::bind('comment', function (string $id) {
            try {
                $commentId = new CommentId($id);
            } catch (InvalidArgumentException $e) {
                abort(404);
            }

            $comment = $this->app->make(CommentRepositoryInterface::class)->findById($commentId);
            if(!$comment) {
                abort(404);
            }
            return $comment;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Blog', '/Routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Blog', '/Routes/api.php'));
    }
}
