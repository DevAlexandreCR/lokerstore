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

Route::apiResource('/products', 'ProductController')->middleware('auth:api');
Route::get('/products', 'ProductController@index')->name('api.index');
Route::get('/products/{product}', 'ProductController@show')->name('api.show');

Route::apiResource('/categories', 'CategoryController')->middleware('auth:api');
Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/{category}', 'CategoryController@show')->name('categories.show');

Route::apiResource('/colors', 'ColorController')->middleware('auth:api')->names('api.colors');
Route::get('/colors', 'ColorController@index')->name('api.colors.index');

Route::apiResource('/type_sizes', 'ColorController')->middleware('auth:api')->names('api.type_sizes');
Route::get('/type_sizes', 'TypeSizeController@index')->name('api.type_sizes.index');

Route::apiResource('/tags', 'TagController')->middleware('auth:api')->names('api.tags');
Route::get('/tags', 'ColorController@index')->name('api.tags.index');

