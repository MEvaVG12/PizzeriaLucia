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
  Route::GET('/home', 'HomeController@index');
  Route::GET('product','ProductController@index');
  Route::GET('promotion/create','PromotionController@create');
  Route::GET('promotion/index','PromotionController@index');
  Route::GET('promotion/show/{id}','PromotionController@show');
  Route::GET('promotion/edit/{id}','PromotionController@edit');
  Route::GET('promotion/delete','PromotionController@delete');
  Route::GET('stock','StockController@index');
});


