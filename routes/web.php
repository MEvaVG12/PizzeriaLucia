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
Route::GET('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
  Route::GET('/', 'HomeController@index');
  Route::get('/home', 'HomeController@index');
});

route::get('product','ProductController@index');
route::get('promotion/create','PromotionController@create');
route::get('promotion/index','PromotionController@index');
route::get('stock','StockController@index');
