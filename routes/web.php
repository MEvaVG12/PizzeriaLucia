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
  return Datatables::eloquent(App\Product::select('products.id', 'products.name', 'products.price', 'products.product_type_id', 'product_types.name as typeName')
  ->join('product_types','products.product_type_id','=','product_types.id'))->make(true);
});
route::get('api/ingredients/{id}',function(){
  return Datatables::eloquent(App\Ingredient::select('ingredients.name as name')
    ->join('ingredient_product',function($join){
        $join->on('ingredient_product.ingredient_id',"=",'ingredients.id')
        ->on('ingredient_product.product_id',"=",$id );
    })
  )->make(true);
});

route::get('stock',function(){
  return View('stock/info');
});

