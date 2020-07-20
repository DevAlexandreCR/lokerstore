<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
|Toda la configuracion de la ruta se encuantra en RouteServiceProvider 
|
*/
// Login routes
Route::get('login', 'Auth\LoginController@showLoginForm')->name('admin.getlogin')->middleware('guest');
Route::post('login', 'Auth\LoginController@login')->name('admin.login')->middleware('before-login-admin');
Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

// Reset pAs
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

// Routes admin management
Route::middleware('auth:admin')->group(function () {
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::resource('users', 'UserController')->except(['create', 'store']);

    Route::resource('products', 'ProductController');
    Route::get('products/active/{product}', 'ProductController@active')->name('products.active');
    Route::put('products/active/{product}', 'ProductController@setActive')->name('products.set_active');

    Route::resource('category', 'CategoryController');
});


