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

	
	//admin URLS  
	Route::get('/',function(){
		return redirect('login');
	});
	
	Route::get('login', 'Auth\LoginController@showLoginForm');
	Route::post('login', 'Auth\LoginController@login')->name('admin.login'); 
	

	Route::group(['middleware'=>['auth','checkadminurl'],'as'=>'admin.'],function() {

		Route::match(['get','post'],'/change-password', 'Admin\AdminController@changePassword')->name('changepassword');
		Route::get('dashboard', 'Admin\DashboardController@index');
		Route::post('logout', 'Auth\LoginController@logout')->name('logout');
		
		// user
		Route::group(['prefix'=>'store'],function() {
			Route::match(['get','post'],'add', 'Admin\UserController@addStore')->name('store.add');
			Route::get('/list', 'Admin\UserController@storeList')->name('store.list');
			Route::get('update/{id}','Admin\UserController@updateStore')->name('store.update');
			Route::get('delete/{id}','Admin\UserController@deleteStore')->name('store.delete');
			Route::post('change-status','Admin\UserController@changeStatus')->name('store.changestatus');
		});

		
		
	});
