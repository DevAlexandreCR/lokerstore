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

Route::middleware(['auth', 'verified', 'user-can'])
    ->prefix('users/{user}')
    ->group(function () {
        Route::get('profile', 'UserController@profile')->name('user.profile');
        Route::get('cart', 'CartController@show')->name('cart.show');
        Route::post('cart/', 'CartController@add')->name('cart.add');
        Route::put('cart/', 'CartController@update')->name('cart.update');
        Route::delete('cart/{stock}', 'CartController@remove')->name('cart.remove');
        Route::get('orders', 'OrderController@index')->name('user.orders.index');
        Route::get('orders/{order}', 'OrderController@show')->name('user.order.show');
        Route::post('orders/status', 'OrderController@statusPayment')->name('user.order.status');
        Route::post('orders', 'OrderController@store')->name('user.order.store');
        Route::post('orders/resend', 'OrderController@resend')->name('user.order.resend');
        Route::post('orders/reverse', 'OrderController@reverse')->name('user.order.reverse');
    });
