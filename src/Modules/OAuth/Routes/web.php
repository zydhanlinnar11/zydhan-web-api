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
use Modules\OAuth\Http\Controllers\OpenIDConfigurationController;

Route::group([
    'as' => 'oidc.well-known.',
    'prefix' => 'oauth/oidc/.well-known',
], function() {
    Route::get('openid-configuration', [OpenIDConfigurationController::class, 'index'])->name('configuration');
    Route::get('certs', [OpenIDConfigurationController::class, 'jwks'])->name('jwks');
});

Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);
    
    $guard = config('passport.guard', null);
    
    Route::middleware(['web', $guard ? 'auth:'.$guard : 'auth'])->group(function () {
        Route::post('/token/refresh', [
            'uses' => 'TransientTokenController@refresh',
            'as' => 'token.refresh',
        ]);
    
        Route::get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
            'as' => 'tokens.index',
        ]);
    
        Route::delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
            'as' => 'tokens.destroy',
        ]);
    
        Route::get('/clients', [
            'uses' => 'ClientController@forUser',
            'as' => 'clients.index',
        ]);
    
        Route::post('/clients', [
            'uses' => 'ClientController@store',
            'as' => 'clients.store',
        ]);
    
        Route::put('/clients/{client_id}', [
            'uses' => 'ClientController@update',
            'as' => 'clients.update',
        ]);
    
        Route::delete('/clients/{client_id}', [
            'uses' => 'ClientController@destroy',
            'as' => 'clients.destroy',
        ]);
    
        Route::get('/scopes', [
            'uses' => 'ScopeController@all',
            'as' => 'scopes.index',
        ]);
    
        Route::get('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@forUser',
            'as' => 'personal.tokens.index',
        ]);
    
        Route::post('/personal-access-tokens', [
            'uses' => 'PersonalAccessTokenController@store',
            'as' => 'personal.tokens.store',
        ]);
    
        Route::delete('/personal-access-tokens/{token_id}', [
            'uses' => 'PersonalAccessTokenController@destroy',
            'as' => 'personal.tokens.destroy',
        ]);
    });
});
