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

Route::get('admin', 'HomeController@index')->middleware('auth:admin')->name('admin.home');

// Login routes
Route::get('admin/login', 'Auth\LoginController@showLoginForm');
Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('logout');

// Reset pAs
Route::get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin/password/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');

// Routes user management
Route::resource('admin/users', 'UserController')
            ->except(['create', 'store'])
            ->middleware('auth:admin');
            
/** Ruta para busqueda de usuarios */
Route::post('admin/users/', 'UserController@index')->name('users.index')->middleware('auth:admin');
