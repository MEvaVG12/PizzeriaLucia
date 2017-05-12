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

Route::GET('promotions','PromotionController@showPromotions');
Route::POST('promotion/promotionDetails','PromotionController@showPromotionDetails');
Route::POST('/promotion/create', 'PromotionController@store');
Route::PUT('promotion/update/{id}','PromotionController@update');
Route::PUT('promotion/delete/{id}','PromotionController@destroy');

Route::GET('sales','SaleController@showSales');
Route::POST('sale/saleDetails','SaleController@showSaleDetails');
Route::POST('sale/create', 'SaleController@store');
Route::PUT('sale/update/{id}','SaleController@update');
Route::PUT('sale/delete/{id}','SaleController@destroy');

Route::GET('stocks', 'StockController@showStocks');
Route::PUT('stock/update/{id}','StockController@update');

Route::GET('products','ProductController@showProducts');
Route::POST('ingredients','ProductController@showIngredients');
Route::PUT('product/update/{id}','ProductController@update');





