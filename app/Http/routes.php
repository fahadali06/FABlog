<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/', 'HomeController@index');
Route::get('/category', 'BlogCategoryController@category');

Route::get('/dashboard', 'HomeController@dashboard');

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/admin/blogs/category', 'BlogCategoryController@index');
Route::get('admin/category/ajax/list', 'BlogCategoryController@category_ajax_list');
Route::post('/admin/blogs/category/store', 'BlogCategoryController@store');
Route::post('/admin/blogs/category/edit/{id}', 'BlogCategoryController@edit');
Route::post('/admin/blogs/category/update/{id}', 'BlogCategoryController@update');
Route::post('/admin/blogs/category/delete/{id}', 'BlogCategoryController@destroy');

Route::get('/admin/blogs/blog/{id}', 'BlogsController@index'); //admin/blogs/blog/ajax/list 
Route::get('/admin/blogs/blog/ajax/list/{id}', 'BlogsController@blogs_ajax_list');
Route::post('/admin/blogs/blog/store', 'BlogsController@store');
Route::post('/admin/blogs/blog/edit/{id}', 'BlogsController@edit');
Route::post('/admin/blogs/blog/update/{id}', 'BlogsController@update');
Route::post('/admin/blogs/blog/delete/{id}', 'BlogsController@destroy');

Route::get('/admin/user/management', 'UsersController@index');
Route::get('/admin/user/management/ajax', 'UsersController@user_management');
Route::get('/admin/user/management/create', 'UsersController@create');
Route::post('/admin/user/management/store', 'UsersController@store');
Route::get('/admin/user/management/edit/{id}', 'UsersController@edit');
Route::post('/admin/user/management/update/{id}', 'UsersController@update');

Route::get('/admin/menu/{id}', 'MenuController@index');
Route::get('/admin/menu', 'MenuController@menu_ajax');
Route::post('/admin/menu/store', 'MenuController@store');

Route::get('/admin/blog/search', 'SearchController@index');
Route::get('/admin/blog/search/ajax', 'SearchController@search_ajax');
