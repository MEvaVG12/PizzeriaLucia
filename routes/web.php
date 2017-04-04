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
route::get('api/products',function(){
  return Datatables::eloquent(App\Product::query())->make(true);
});

route::get('stock','StockController@index');
route::get('api/stocks',function(){
  return Datatables::eloquent(App\Stock::select('stocks.id', 'stocks.ingredient_id', 'stocks.amount', 'ingredients.name as name')
            ->join('ingredients','ingredients.id','=','stocks.ingredient_id'))->make(true);
});
