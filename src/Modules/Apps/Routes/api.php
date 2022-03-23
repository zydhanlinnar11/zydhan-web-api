<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Apps\Http\Controllers\AuthorizationController;

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

Route::middleware('auth:sanctum')->prefix('apps')->name('apps.')->group(function () {
    Route::get('/create-token', [AuthorizationController::class, 'create_token']);
});