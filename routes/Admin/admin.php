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
Route::get('/', 'HomeController@index')->name('admin.home')->middleware('auth:admin');

// Login routes
Route::get('login', 'Auth\LoginController@showLoginForm');
Route::post('login', 'Auth\LoginController@login')->name('admin.login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Reset pAs
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

// Routes user management
Route::resource('users', 'UserController')->except(['create', 'store']);
            
/** Ruta para busqueda de usuarios */
Route::post('users/', 'UserController@index')->name('users.index');
