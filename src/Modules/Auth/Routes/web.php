<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\SocialAuthController;

Route::prefix('auth')->name('auth.')->group(function() {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/{provider:string}/redirect', [SocialAuthController::class, 'handleRedirect']);
    Route::get('/{provider:string}/callback', [SocialAuthController::class, 'handleCallback']);
    Route::delete('/logout', [AuthController::class, 'logout']);
});