<?php

use Illuminate\Support\Facades\Route;
use Modules\Guestbook\Http\Controllers\GuestbookController;

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

Route::name('guestbook.')
    ->prefix('guestbook')
    ->group(function() {
        Route::name('guestbooks.')
            ->prefix('guestbooks')
            ->group(function() {
                Route::get('/', [GuestbookController::class, 'index'])->name('index');
                Route::middleware('auth:sanctum')->post('/', [GuestbookController::class, 'store'])->name('store');
            });
    });