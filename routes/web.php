<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes(['verify' => true]);

// los usuarios inhabilitados no pueden acceder al index
Route::get('/', 'HomeController@index')
    ->middleware('enabled')
    ->middleware('guest:admin')
    ->middleware('guest')
    ->name('index');

Route::get('home/{any?}', 'HomeController@home')
    ->middleware('enabled')->name('home')
    ->where('any', '.*');

Route::get('disabled-user', 'DisabledUserController@index');

Route::get('products/{product}', 'ProductController@show')->name('web.products.show');

Route::middleware('verified')
    ->group(function () {
        Route::get('user/{user}/cart', 'CartController@show')->name('cart.show');
        Route::post('user/{user}/cart/', 'CartController@add')->name('cart.add');
        Route::put('user/{user}/cart/', 'CartController@update')->name('cart.update');
        Route::delete('user/{user}/cart/{stock}', 'CartController@remove')->name('cart.remove');
    });
