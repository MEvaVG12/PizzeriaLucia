<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Sale;
use App\SaleDetail;
use App\Product;
use App\Promotion;
use Notification;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::all()->take(10);
        return View('promotion.index')->with('promotions',$promotions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.create');
    }

    /**
     * Show the form for deleting a  resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        return view('promotion.delete');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'client' => 'required',
            'orderDate' => 'required',
            //'deliveryDate' => 'required',
        ]);

        //creación de fecha
        $time = strtotime($request->input('orderDate'));
        $newformat = date('Y-m-d',$time);

        $p = new Sale();
        $p->client = $request->input('client');
        $p->orderDate = $newformat;
        $p->phoneNumer = 'ver';
        $p->deliveryDate = $newformat;
        $p->save();


        $products = $request->input('products');

        foreach($products as $product)
        {
            $currentProduct = Product::findOrFail($product['id']);
            $d = new SaleDetail();
            $d->amount = $product['amount'];
            $d->product()->associate($currentProduct);
            $d->sale()->associate($p);
            $d->save();
        }

        /*$promotions = $request->input('promotions');

        foreach($promotions as $promotion)
        {
            $currentPromotion = Promotion::findOrFail($promotion['id']);
            $d = new SaleDetail();
            $d->amount = $promotion['amount'];
            $d->promotion()->associate($currentPromotion);
            $d->save();
        }*/

     return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);
        return View('promotion.show' , ['promotion' => $promotion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        return View('promotion.edit' , ['promotion' => $promotion]);
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
        /*$this->validate($request, [
            'price' => 'required| numeric',
        ]);*/

        $promotion = Promotion::findOrFail($id);
        $promotion->price = $request->input('price');

        $productsUpdate = $request->input('productsUpdate');

        foreach($productsUpdate as $productId)
        {
            $promotionDetail = PromotionDetail::findOrFail($productId['id']);
            $promotionDetail->amount = $productId['newValue'];
            $promotionDetail->save();
        }

        $promotion->save();
    }

        /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $product = Promotion::findOrFail($id);
        $product->isDeleted = true;
        $product->save();
    }


    /**
     * Display ingredients list of specified product (by id).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPromotionDetails(Request $request)
    {
        $promotion_details = DB::table('promotion_details')->join('products', 'products.id', '=', 'promotion_details.product_id') ->select('promotion_details.id', 'promotion_details.amount', 'products.name as productName')->where('promotion_details.promotion_id', '=', $request->input('id'))->get();

        return response()->json(['success' => true, 'data' => $promotion_details]);
    }

    /**
     * Display products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPromotions()
    {
        $promotions = DB::table('promotions') ->select('promotions.id', 'promotions.name', 'promotions.price')->where('isDeleted', '=', '0')->get();

        return response()->json(['success' => true, 'data' => $promotions]);
    }

        /**
     * Display products list.
     *
     * @return \Illuminate\Http\Response
     */
    public function showProducts()
    {
        $promotionDetail = DB::table('promotion_details')->join('products', 'products.id', '=', 'promotion_details.product_id') ->select('promotion_details.id', 'promotion_details.amount as cantidad', 'products.name as productName')->where('promotion_details.promotion_id', '=', '11')->get();

        return response()->json(['success' => true, 'data' => $promotionDetail]);
    }

}
