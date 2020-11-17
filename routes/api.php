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

    Route::middleware('auth:api')
        ->prefix('/products')
        ->group(function () {
            Route::put('/stocks/{stock}', 'StockController@update')
                ->name('api.stocks.update');

            Route::post('/photos', 'PhotosController@store')
                ->name('api.photos.store');

            Route::delete('/photos', 'PhotosController@destroy')
                ->name('api.photos.destroy');
        });

    Route::middleware('auth:api')
        ->apiResource('products', 'ProductController')
        ->except('index', 'show')
        ->name('store', 'api.products.store')
        ->name('destroy', 'api.products.destroy')
        ->name('update', 'api.products.update');

    Route::get('/products', 'ProductController@index')->name('api.index');
    Route::get('/products/{product}', 'ProductController@show')->name('api.show');

    Route::get('/categories', 'CategoryController@index')->name('categories.index');
    Route::get('/categories/{category}', 'CategoryController@show')->name('categories.show');

    Route::get('/colors', 'ColorController@index')->name('api.colors.index');

    Route::get('/type_sizes', 'TypeSizeController@index')->name('api.type_sizes.index');

    Route::get('/tags', 'TagController@index')->name('api.tags.index');
