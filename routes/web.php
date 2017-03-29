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
  Route::GET('/', function(){
		if(Auth::check()){
			 //return Redirect::action('CatalogController@getIndex');
       return view('home');
		}else {
			return Redirect::action('HomeController@index');
		}
	});
  Route::get('/home', function(){
    if(Auth::check()){
      return view('home');
       //return Redirect::action('CatalogController@getIndex');
    }else {
      return Redirect::action('HomeController@index');
    }
  });
});
