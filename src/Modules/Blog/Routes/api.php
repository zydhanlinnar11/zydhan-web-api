<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\AdminPostController;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\Blog\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('blog')->name('blog.')->group(function() {
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [BlogController::class, 'index']);
        Route::get('/portfolio', [BlogController::class, 'portfolio']);
        Route::get('/{post}', [BlogController::class, 'show']);
        Route::get('/{post}/comments', [BlogController::class, 'getPostComments']);
        Route::middleware('auth:sanctum')->post('/{post}/comments', [BlogController::class, 'createPostComment']);
    });

    Route::middleware('auth:sanctum')->prefix('comments')->name('comments.')->group(function () {
        Route::patch('/{comment}', [CommentController::class, 'update']);
        Route::delete('/{comment}', [CommentController::class, 'destroy']);
    });

    Route::middleware('auth:sanctum')->prefix('admin')->name('admin.')->group(function() {
        Route::prefix('posts')->name('posts.')->group(function() {
            Route::get('/', [AdminPostController::class, 'index']);
            Route::post('/', [AdminPostController::class, 'store']);
            Route::get('/{admin_post}', [AdminPostController::class, 'show']);
            Route::patch('/{admin_post}', [AdminPostController::class, 'update']);
            Route::delete('/{admin_post}', [AdminPostController::class, 'destroy']);
        });
    });
});