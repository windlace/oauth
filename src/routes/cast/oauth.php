<?php
/*
|--------------------------------------------------------------------------
| Cast\OAuth Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Cast\OAuth package.
|
*/
Route::group([
            'namespace'  => 'Cast\OAuth\app\Http\Controllers',
            'middleware' => ['web'],
            'prefix'     => config('cast.oauth.route_prefix', 'oauth'),
    ], function () {
        Route::get('login/{serivce}', 'OAuthController@redirectToProvider');
        Route::get('login/{service}/callback', 'OAuthController@handleProviderCallback');
    });
