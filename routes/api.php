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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login')->name('login');
Route::post('logout', 'API\RegisterController@logout')->name('logout.api');
Route::middleware('auth:api')->group(function() {
    Route::apiResource('/products', 'ProductController');
});

Route::group(['prefix' => 'products'],function(){
    Route::apiResource('/{product}/reviews','ReviewController');
});
