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
  return Datatables::eloquent(App\Product::select('products.id', 'products.product_type_id', 'product_types.name as typeName', 'products.name', 'products.price')
            ->join('product_types','product_types.id','=','products.product_type_id')
          )->make(true);
});
//'ingredient_product.ingredient_id', 'ingredient_product.product_id', 'ingredients.id', 'ingredients.name as ingredientName'
//->join('ingredient_product', 'ingredient_product.product_id', '=', 'products.id')
//->join('ingredients', 'ingredients.id', '=', 'ingredient_product.ingredient_id')
