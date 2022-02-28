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
    Route::get('/posts', [BlogController::class, 'index']);
    Route::get('/posts/{slug:string}', [BlogController::class, 'show']);
    Route::get('/posts/{slug:string}/comments', [BlogController::class, 'getPostComments']);
    Route::post('/posts/{slug:string}/comments', [BlogController::class, 'createPostComment']);


    Route::patch('/comments/{id:string}', [CommentController::class, 'update']);
    Route::delete('/comments/{id:string}', [CommentController::class, 'destroy']);

    Route::middleware('auth:sanctum')->prefix('admin')->name('admin.')->group(function() {
        Route::prefix('posts')->name('posts.')->group(function() {
            Route::get('/', [AdminPostController::class, 'index']);
        });
    });
});