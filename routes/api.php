<?php

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

Route::resource('/products', 'Api\ProductController')->except('edit', 'create')->middleware('auth:api');
Route::get('/products', 'Api\ProductController@index')->name('api.index');
Route::get('/products/{product}', 'Api\ProductController@show')->name('api.show');
