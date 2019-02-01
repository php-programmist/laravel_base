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
Route::get('/articles', 'ArticleController@index')->name('articlesAll');
Route::get('articles/{slug}', 'ArticleController@show')->name('articles')->where('slug', '[\w-]+');
Route::get('articles/cat/{cat_slug}', ['uses' => 'ArticleController@index', 'as' => 'articlesCat'])->where('slug',
    '[\w-]+');
Route::resource('comment', 'CommentController', ['only' => 'store']);

Route::get('/contacts', 'ContactController@index')->name('contacts');
Route::post('/contacts', 'ContactController@post');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', 'Admin\IndexController@index')->name('dashboard');
    
    Route::resource('/articles', 'Admin\ArticleController');
    Route::resource('/users', 'Admin\UserController');
    Route::resource('/menus', 'Admin\MenuController');
    Route::resource('/categories', 'Admin\CategoryController');
    Route::resource('/comments', 'Admin\CommentController');
    Route::resource('/tags', 'Admin\TagController');
    Route::resource('/groups', 'Admin\GroupController');
});
	
