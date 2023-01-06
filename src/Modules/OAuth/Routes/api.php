<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'as' => 'passport.',
    'prefix' => 'oauth',
    'namespace' => '\Laravel\Passport\Http\Controllers',
    'middleware' => 'auth:sanctum',
], function () {
    Route::get('/authorize', [
        'uses' => '\Modules\OAuth\Http\Controllers\AuthorizationController@authorize',
        'as' => 'authorizations.authorize',
    ]);
    
    Route::delete('/authorize', [
        'uses' => '\Modules\OAuth\Http\Controllers\DenyAuthorizationController@deny',
        'as' => 'authorizations.deny',
    ]);
    
    Route::post('/authorize', [
        'uses' => '\Modules\OAuth\Http\Controllers\ApproveAuthorizationController@approve',
        'as' => 'authorizations.approve',
    ]);

});

Route::get('/oauth/clients/info', [
    'uses' => '\Modules\OAuth\Http\Controllers\ClientInfoController@info',
    'as' => 'oauth.clients.info',
]);

Route::match(['GET', 'POST'], '/userinfo', [
    'uses' => '\Modules\OAuth\Http\Controllers\UserInfoController@show',
    'as' => 'oidc.userinfo',
    'prefix' => 'oauth/oidc',
    'middleware' => 'auth:api'
]);