<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Sale;
use App\SaleDetail;
use App\Product;
use App\Promotion;
use DateTime;
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
        return View('sale.index');
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


        $order = new DateTime($request->input('orderDate'));
        $order->setTime(substr($request->input('orderTime'), 0, 2), substr($request->input('orderTime'), -2));

        $delivery = new DateTime($request->input('deliveryDate'));
        $delivery->setTime(substr($request->input('deliveryTime'), 0, 2), substr($request->input('orderTime'), -2));

        $p = new Sale();
        $p->client = $request->input('client');
        $p->phoneNumer = '';
        $p->orderDateTime = $order;
        $p->deliveryDateTime = $delivery;
        $p->save();


        $products = $request->input('products');
        if (is_array($products) )
        {
        foreach($products as $product)
        {
            $currentProduct = Product::findOrFail($product['id']);
            $d = new SaleDetail();
            $d->price = $product['price'];
            $d->amount = $product['amount'];
            $d->product()->associate($currentProduct);
            $d->sale()->associate($p);
            $d->save();
        }
    }

        $promotions = $request->input('promotions');

        if (is_array($promotions) )
        {
        foreach($promotions as $promotion)
        {
            $currentPromotion = Promotion::findOrFail($promotion['id']);
            $d = new SaleDetail();
            $d->price = $promotion['price'];
            $d->amount = $promotion['amount'];
            $d->promotion()->associate($currentPromotion);
            $d->sale()->associate($p);
            $d->save();
        }
    }

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

        if (is_array($productsUpdate) )
        {
        foreach($productsUpdate as $productId)
        {
            $promotionDetail = PromotionDetail::findOrFail($productId['id']);
            $promotionDetail->amount = $productId['newValue'];
            $promotionDetail->save();
        }
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
     * Display sales list.
     *
     * @return \Illuminate\Http\Response
     */
    public function showSales()
    {
/**        $promotions = DB::table('sales') ->select('sales.id', 'sales.client', 'sales.orderDate', 'sales.deliveryDate')->where('isDeleted', '=', '0')->get();/
        /*
        */

        $sales = DB::table('sales') ->select('sales.id', 'sales.client', 'sales.orderDate', 'sales.deliveryDate')->get();

        return response()->json(['success' => true, 'data' => $sales]);
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

    /**
     * Display ingredients list of specified product (by id).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showSaleDetails(Request $request)
    {

    }

}
