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
	
	
	Route::group([ 'middleware' => [ 'web' ], ], function () {
		/** @noinspection PhpUndefinedMethodInspection */
		Auth::routes();
		Route::get('/', 'ArticleController@index')->name('home');
		Route::get('articles/{slug}', 'ArticleController@show')->name('articles');
	});
	
	Route::group([ 'middleware' => [ 'web', 'auth' ], 'prefix' => 'admin', 'as' => 'admin.' ], function () {
		Route::get('/', function () {
			return redirect()->route('admin.dashboard');
		});
		Route::get('/dashboard', 'AdminController@index')->name('dashboard');
		Route::get('/articles', 'AdminArticleController@list')->name('articles');
		Route::get('/articles/edit/{id}', 'AdminArticleController@index')->name('article_update');
		Route::get('/articles/edit', 'AdminArticleController@index')->name('article_new');
		Route::post('/articles/edit', 'AdminArticleController@save')->name('article_save');
		
	});
	
