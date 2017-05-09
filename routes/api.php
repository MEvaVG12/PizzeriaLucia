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

Route::post('/sale/create', 'SaleController@store');
Route::post('/promotion/create', 'PromotionController@store');
//Route::POST('/promotion/create', function() { });

Route::put('stock/update/{id}','StockController@update');
Route::put('stock/updates','StockController@updates');
Route::get('stocks', function(){
  return Datatables::eloquent(App\Stock::select('stocks.id', 'stocks.ingredient_id', 'stocks.amount', 'ingredients.name as name')
            ->join('ingredients','ingredients.id','=','stocks.ingredient_id'))->make(true);
});

Route::get('products','ProductController@showProducts');
Route::post('promotion/{id}/products','PromotionController@showProducts');
Route::put('sale/update/{id}','SaleController@update');
//Route::get('stocks','StockController@showStock');
Route::post('ingredients','ProductController@showIngredients');
Route::get('sale/index','SaleController@showSales');
Route::put('sale/delete/{id}','SaleController@destroy');
Route::post('sale/index/saleDetails','SaleController@showSaleDetails');
Route::get('promotion/index','PromotionController@showPromotions');
Route::post('promotion/index/promotionDetails','PromotionController@showPromotionDetails');
Route::put('product/update/{id}','ProductController@update');
Route::get('product/get/{id}','ProductController@get');
Route::put('promotion/delete/{id}','PromotionController@destroy');
Route::put('promotion/update/{id}','PromotionController@update');
