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
use Modules\Auth\Http\Controllers\CallbackController;
use Modules\Auth\Http\Controllers\LogoutController;
use Modules\Auth\Http\Controllers\RedirectController;

Route::prefix('auth')->name('auth.')->group(function() {
    Route::get('/{socialMedia}/redirect', [RedirectController::class, 'redirect'])->name('redirect');
    Route::get('/{socialMedia}/callback', [CallbackController::class, 'handle'])->name('callback');
    Route::delete('/logout', [LogoutController::class, 'logout'])->name('logout');
});
