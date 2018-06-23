<?php
	
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
	
	
	/** @noinspection PhpUndefinedMethodInspection */
	Auth::routes();
	Route::get('/', 'ArticleController@index')->name('home');
	Route::get('articles/{slug}', 'ArticleController@show')->name('articles');
	
	
	Route::group([ 'middleware' => [ 'auth' ], 'prefix' => 'admin', 'as' => 'admin.' ], function () {
		Route::get('/', function () {
			return redirect()->route('admin.users.index');
		});
		//Route::get('/dashboard', 'AdminController@index')->name('dashboard');
		
		Route::resource('/articles', 'AdminArticleController');
		Route::resource('/users', 'AdminUserController');
	});
	
