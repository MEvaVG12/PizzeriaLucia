<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

route::put('stock/update/{id}','StockController@update');

route::get('stocks', function(){
  return Datatables::eloquent(App\Stock::select('stocks.id', 'stocks.ingredient_id', 'stocks.amount', 'ingredients.name as name')
            ->join('ingredients','ingredients.id','=','stocks.ingredient_id'))->make(true);
});

route::get('products',function(){
  return Datatables::eloquent(App\Product::select('products.id', 'products.name', 'products.price', 'products.product_type_id', 'product_types.name as typeName')
  ->join('product_types','products.product_type_id','=','product_types.id'))->make(true);
});

route::get('promotion/create',function(){
  return Datatables::eloquent(App\Product::select('products.id', 'products.name'))->make(true);
});

route::get('promotion/index',function(){
  return Datatables::eloquent(App\Promotion::select('promotions.id', 'promotions.name', 'promotions.price', 'promotion_details.id', 'promotion_details.promotion_id', 'promotion_details.product_id', 'promotion_details.amount', 'products.id', 'products.name as nameProduct')
  ->join('promotion_details','promotion_details.promotion_id',"=",'promotions.id')
  ->join ('products', 'products.id', '=', 'promotion_details.product_id')
  )->make(true);
});

route::get('ingredients/{id}',function(){
  return Datatables::eloquent(App\Ingredient::select('ingredients.name as name')
    ->join('ingredient_product',function($join){
        $join->on('ingredient_product.ingredient_id',"=",'ingredients.id')
        ->on('ingredient_product.product_id',"=",$id );
    })
  )->make(true);
});
