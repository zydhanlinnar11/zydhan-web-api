<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\SocialMediaController;

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

Route::middleware(['auth:sanctum', 'admin'])
    ->name('admin.')
    ->prefix('admin')
    ->group(function() {
        Route::apiResource('social-media', SocialMediaController::class)
            ->except(['destroy']);
    });