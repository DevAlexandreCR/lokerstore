<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admins Routes
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
Route::middleware(['auth:admin', 'enabled:admin'])->group(function () {
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::resource('users', 'UserController')->except(['create', 'store']);

    Route::resource('products', 'ProductController');
    Route::get('products/active/{product}', 'ProductController@active')->name('products.active');
    Route::put('products/active/{product}', 'ProductController@setActive')->name('products.set_active');

    Route::resource('category', 'CategoryController')->except(['show', 'create', 'edit']);
    Route::resource('tags', 'TagController')->except(['show', 'create', 'edit']);
    Route::resource('stocks', 'StockController')->except(['show', 'edit', 'create']);
    Route::get('stocks/create/{product}', 'StockController@create')->name('stocks.create');

    Route::resource('admins', 'AdminController')
        ->names('admins')
        ->except('edit', 'create');

    Route::resource('roles', 'RoleController')
        ->names('roles')
        ->only('store', 'index', 'update', 'destroy');

    Route::resource('permissions', 'PermissionController')
        ->names('permissions')
        ->only('store', 'update', 'destroy');

    Route::put('update-permissions/{admin}', 'AdminPermissionsController@update')
        ->name('update-permissions');

    Route::resource('orders', 'OrdersController')
        ->names('orders')
        ->only('index', 'show', 'destroy', 'update');
    Route::get('orders/{order}/verify', 'OrdersController@verify')->name('orders.verify');
    Route::get('orders/{order}/reverse', 'OrdersController@reverse')->name('orders.reverse');

    Route::resource('order_details', 'OrderDetailsController')
        ->names('order_details')
        ->only('destroy', 'update');
});

