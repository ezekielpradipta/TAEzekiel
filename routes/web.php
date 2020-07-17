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

    Route::get('/dosendashboard', 'DosenController@dashboard')->name('dosen.dashboard.index');
	Route::get('/tak', 'DosenTAKController@index')->name('dosen.tak.index');
	Route::post('/tak', 'DosenTAKController@store')->name('dosen.tak.store');
	Route::get('/tak/cekKegiatan/{id?}','DosenTAKController@cekKegiatan')->name('dosen.tak.cekKegiatan');
	Route::get('/tak/cekTingkat/{id?}','DosenTAKController@cekTingkat')->name('dosen.tak.cekTingkat');
	Route::get('/tak/cekPilar/{id?}','DosenTAKController@cekPilar')->name('dosen.tak.cekPilar');
	Route::post('register/cekemail', 'RegisterController@cekEmail')->name('register.cekEmail');
	Route::post('register/cekuname', 'RegisterController@cekUsername')->name('register.cekUsername');
	
Route::group(['middleware' => ['guest']], function () {    
	Route::get('login', 'LoginController@login')->name('login');
	Route::post('login', 'LoginController@ceklogin')->name('login');
	Route::get('register', 'RegisterController@register')->name('register');
	Route::post('register', 'RegisterController@daftar')->name('register');

});
Route::group(['middleware'=>['auth']],function(){
	Route::get('logout', 'LoginController@logout')->name('logout');
	Route::get('dashboard','LoginController@cekRole')->name('dashboard');

	Route::group(['middleware'=>['admin']],function(){
		Route::namespace('Admin')->group(function(){
			Route::prefix('admin')->group(function(){
				Route::get('/', 'DashboardController@dashboard')->name('admin.dashboard.index');
				Route::get('profile', 'AdminController@index')->name('admin.profile.index');
				Route::put('profile', 'AdminController@update')->name('admin.profile.update');
					Route::prefix('data')->group(function(){
						Route::prefix('mahasiswa')->group(function(){
							Route::get('/','MahasiswaController@index')->name('admin.mahasiswa.index');
							Route::get('/data','MahasiswaController@data')->name('admin.mahasiswa.data');	
						});
						Route::resource('dosen','DosenController',['as'=>'admin'])->except('show');
						Route::get('dosen/data','DosenController@data')->name('admin.dosen.data');
						
						Route::resource('kemahasiswaan','KemahasiswaanController',['as'=>'admin'])->except('show');
						Route::get('kemahasiswaan/data','KemahasiswaanController@data')->name('admin.kemahasiswaan.data');

						Route::resource('takkumulatif','TAKKumulatifController',['as'=>'admin'])->except('show');
						Route::get('takkumulatif/data','TAKKumulatifController@data')->name('admin.takkumulatif.data');	

						Route::resource('tak','TAKController',['as'=>'admin'])->except('show');
						Route::get('tak/data','TAKController@data')->name('admin.tak.data');
						Route::get('tak/cekKegiatan/{id?}','TAKController@cekKegiatan')->name('admin.tak.cekKegiatan');
						Route::get('tak/cekTingkat/{id?}','TAKController@cekTingkat')->name('admin.tak.cekTingkat');
						Route::get('tak/cekPilar/{id?}','TAKController@cekPilar')->name('admin.tak.cekPilar');
						Route::get('tak/{tak}/cekPilar/{id}','TAKController@cekPilarEdit');
					});
					Route::prefix('config')->group(function(){
						Route::resource('kategoriTAK','KategoriTAKController',['as'=>'admin'])->except('show');
						Route::get('kategoriTAK/data','KategoriTAKController@data')->name('admin.kategoriTAK.data');

						Route::resource('pilarTAK','PilarTAKController',['as'=>'admin'])->except('show');
						Route::get('pilarTAK/data','PilarTAKController@data')->name('admin.pilarTAK.data');

						Route::resource('kegiatanTAK','KegiatanTAKController',['as'=>'admin'])->except('show');
						
						Route::resource('tingkatTAK','TingkatTAKController',['as'=>'admin'])->except('show');

						Route::resource('prodi','ProdiController',['as'=>'admin'])->except('show');
						Route::get('prodi/data','ProdiController@data')->name('admin.prodi.data');

						Route::resource('angkatan','AngkatanController',['as'=>'admin'])->except('show');
						Route::get('angkatan/data','AngkatanController@data')->name('admin.angkatan.data');
					});
			});
		});
	});

	Route::group(['middleware'=>['mahasiswa']],function(){
		Route::namespace('Mahasiswa')->group(function(){
			Route::get('/form','TestController@index')->name('isiDataMahasiswa');
			Route::post('/form/konfirm','TestController@confirm')->name('konfirmformmahasiswa');
		});
	});
});

Route::get('/home', 'HomeController@index')->name('home');

