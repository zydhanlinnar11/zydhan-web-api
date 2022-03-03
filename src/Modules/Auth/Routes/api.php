<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\UserController;

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

Route::middleware('api')->prefix('auth')->name('auth.')->group(function() {
    Route::post('/register', [AuthController::class, 'store']);
    Route::middleware('auth:sanctum')->get('/authenticated-user', [AuthController::class, 'getAuthenticatedUser']);

    Route::middleware('auth:sanctum')->prefix('user')->name('user.')->group(function() {
        Route::get('/', [UserController::class, 'show']);
        Route::patch('/', [UserController::class, 'update']);
        Route::delete('/unlink-social/{social_provider}', [UserController::class, 'unlinkSocialAccount']);
        Route::patch('/change-password', [UserController::class, 'changePassword']);
    });
    Route::post('/user/forgot-password', [UserController::class, 'forgotPassword']);
    Route::post('/user/reset-password', [UserController::class, 'resetPassword']);
});