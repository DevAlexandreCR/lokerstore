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

Route::get('/', 'HomeController@index')->middleware('enabled')->middleware('guest:admin')->middleware('guest')->name('index'); // los usuarios inhabilitados no pueden acceder al index
Route::get('home/{any?}', 'HomeController@home')->middleware('enabled')->name('home')->where('any', '.*');

Route::get('disabled-user', 'DisabledUserController@index');
