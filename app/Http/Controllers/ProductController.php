<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all()->take(10);
        return View('product')->with('products',$products);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    /**
     * Display ingredients list of specified product (by id).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showIngredients(Request $request)
    {
        $product = Product::find($request->input('id'))->ingredients;

        return response()->json(['success' => true, 'data' => $product]);
    }

    /**
     * Display products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProducts()
    {
        $products = DB::table('products')->join('product_types', 'product_types.id', '=', 'products.product_type_id') ->select('products.id', 'products.name', 'products.price', 'product_types.name AS typeName')->get();

        return response()->json(['success' => true, 'data' => $products]);
    }

}
