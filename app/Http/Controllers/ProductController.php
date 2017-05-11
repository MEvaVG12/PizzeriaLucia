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
        return View('product.product')->with('products',$products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'price' => 'required| numeric',
        ]);

        $product = Product::findOrFail($id);
        $product->price = $request->input('price');
        $product->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return View('product.show' , ['product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $product = Product::findOrFail($id);
        return response()->json([$product]);
    }


    public function destroy(Request $request)
    {
        $product = Product::FindOrFail($request->input('id'));
        $result = $product->delete();
        if ($result)
        {
            return response()->json(['success'=>'true']); 
        }
        else
        {
            return response()->json(['success'=> 'false']);
        }
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
        $products = DB::table('products')->join('product_types', 'product_types.id', '=', 'products.product_type_id') ->select('products.id', 'products.name', 'products.price', 'product_types.name AS typeProduct')->get();

        return response()->json(['success' => true, 'data' => $products]);
    }

}
