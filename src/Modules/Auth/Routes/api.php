<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\SocialMediaListController;
use Modules\Auth\Http\Controllers\UnlinkSocialController;
use Modules\Auth\Http\Controllers\UpdatePersonalInfoController;
use Modules\Auth\Http\Controllers\UserInfoController;

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

Route::middleware('auth:sanctum')->prefix('auth')->group(function() {
    Route::get('/user', [UserInfoController::class, 'show']);
    Route::patch('/user', [UpdatePersonalInfoController::class, 'update']);
    Route::delete('/user/social-media/{socialMedia}', [UnlinkSocialController::class, 'unlink']);
});

Route::get('/auth/social-media', [SocialMediaListController::class, 'index']);
