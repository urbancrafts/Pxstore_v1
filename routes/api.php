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

Route::post('admin/register', 'App\Http\Controllers\API\RegisterController@register');
Route::post('admin/login', 'App\Http\Controllers\API\RegisterController@login');
Route::post('admin/{admin}/logout', 'App\Http\Controllers\API\RegisterController@logout');


Route::get('merchants', 'App\Http\Controllers\API\SellerAuthController@index');
Route::get('merchants/{merchant}', 'App\Http\Controllers\API\SellerAuthController@show');
Route::post('merchants/{merchant}/activate', 'App\Http\Controllers\API\SellerAuthController@activate');
Route::post('merchants/{merchant}/deactivate', 'App\Http\Controllers\API\SellerAuthController@deactivate');
Route::put('merchants/{merchant}', 'App\Http\Controllers\API\SellerAuthController@update');
Route::post('merchants/create', 'App\Http\Controllers\API\SellerAuthController@createStore');
Route::post('seller/login', 'App\Http\Controllers\API\SellerAuthController@login');
Route::post('seller/{seller}/logout', 'App\Http\Controllers\API\SellerAuthController@logout');

Route::post('buyer/login', 'App\Http\Controllers\API\BuyerAuthController@login');
Route::post('buyer/{buyer}/logout', 'App\Http\Controllers\API\BuyerAuthController@logout');
Route::get('buyers', 'App\Http\Controllers\API\BuyerAuthController@index');
Route::get('buyer/{buyer}', 'App\Http\Controllers\API\BuyerAuthController@show');
Route::put('buyer/{buyer}', 'App\Http\Controllers\API\BuyerAuthController@update');
Route::post('buyer/{buyer}/activate', 'App\Http\Controllers\API\BuyerAuthController@activate');
Route::post('buyer/{buyer}/deactivate', 'App\Http\Controllers\API\BuyerAuthController@deactivate');
Route::post('buyer/register', 'App\Http\Controllers\API\BuyerAuthController@register');
   
Route::middleware('auth:api')->group( function () {
    // Route::resource('product', 'API\ProductController');
});


Route::apiResource('product','App\Http\Controllers\ProductController');

Route::prefix('product')->group(function(){
    Route::apiResource('/{product}/reviews','App\Http\Controllers\ReviewsController');
});
