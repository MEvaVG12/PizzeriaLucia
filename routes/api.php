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

Route::put('stock/update/{id}','StockController@update');

Route::get('stocks', function(){
  return Datatables::eloquent(App\Stock::select('stocks.id', 'stocks.ingredient_id', 'stocks.amount', 'ingredients.name as name')
            ->join('ingredients','ingredients.id','=','stocks.ingredient_id'))->make(true);
});

Route::get('products','ProductController@showProducts');

//Route::get('stocks','StockController@showStock');

Route::post('ingredients','ProductController@showIngredients');