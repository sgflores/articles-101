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

Route::prefix('auth')->group(function() {
    Route::post('login', 'API\Auth\AuthController@login');
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('auth')->group(function() {
        Route::get('user', 'API\Auth\AuthController@user');
        Route::post('logout', 'API\Auth\AuthController@logout');
    });
    Route::apiResource('client', 'API\ClientController');
    Route::apiResource('article', 'API\ArticleController');
});