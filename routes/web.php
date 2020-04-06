<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['guest']], function () {    
Route::get('login', 'LoginController@login')->name('login');
Route::post('login', 'LoginController@ceklogin')->name('login');
Route::get('register', 'RegisterController@register')->name('register');
Route::post('register', 'RegisterController@daftar')->name('register');
Route::post('register/cekemail', 'RegisterController@cekEmail')->name('register.cekEmail');
Route::post('register/cekname', 'RegisterController@cekNama')->name('register.cekNama');
Route::post('register/cekuname', 'RegisterController@cekUsername')->name('register.cekUsername');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'LoginController@logout')->name('logout');