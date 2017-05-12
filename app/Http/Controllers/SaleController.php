<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Sale;
use App\SaleDetail;
use App\Product;
use App\Promotion;
use DateTime;


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
            'deliveryDate' => 'required',
        ]);

        $formato = 'd/m/Y';
        $order =DateTime::createFromFormat($formato, $request->input('orderDate'));
        $order->setTime(substr($request->input('orderTime'), 0, 2), substr($request->input('orderTime'), -2));

        $delivery =DateTime::createFromFormat($formato, $request->input('deliveryDate'));
        $delivery->setTime(substr($request->input('deliveryTime'), 0, 2), substr($request->input('deliveryTime'), -2));

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
        $sale = Sale::findOrFail($id);
        return View('sale.show' , ['sale' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return View('sale.edit' , ['sale' => $sale]);
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
        $formato = 'd/m/Y';
        $delivery =DateTime::createFromFormat($formato, $request->input('deliveryDate'));
        $delivery->setTime(substr($request->input('deliveryTime'), 0, 2), substr($request->input('deliveryTime'), -2));

        $sale = Sale::findOrFail($id);
        $sale->deliveryDateTime = $delivery;

        $productsUpdate = $request->input('productsUpdate');
        if (is_array($productsUpdate) ){
            foreach($productsUpdate as $productId)
            {
                $promotionDetail = SaleDetail::findOrFail($productId['id']);
                $promotionDetail->amount = $productId['newValue'];
                $promotionDetail->save();
            }
        }

        //TODO ver de poner todo en uno
        $promotionsUpdate = $request->input('promotionsUpdate');
        if (is_array($promotionsUpdate) ){
            foreach($promotionsUpdate as $promotionId)
            {
                $promotionDetail = SaleDetail::findOrFail($promotionId['id']);
                $promotionDetail->amount = $promotionId['newValue'];
                $promotionDetail->save();
            }
        }

        $productsDelete = $request->input('productsDelete');
        if (is_array($productsDelete) ){
            foreach($productsDelete as $productId)
            {
                $promotionDetail = SaleDetail::findOrFail($productId['id']);
                $promotionDetail->isDeleted = true;
                $promotionDetail->save();
            }
        }

        $promotionsDelete = $request->input('promotionsDelete');
        if (is_array($promotionsDelete) ){
            foreach($promotionsDelete as $promotionId)
            {
                $promotionDetail = SaleDetail::findOrFail($promotionId['id']);
                $promotionDetail->isDeleted = true;
                $promotionDetail->save();
            }
        }

        $productsNew = $request->input('productsNew');
        if (is_array($productsNew) ){
            foreach($productsNew as $productId)
            {
                $product = Product::findOrFail($productId['id']);
                $d = new SaleDetail();
                $d->amount = $productId['amount'];
                $d->price = $productId['price'];
                $d->product()->associate($product);
                $d->sale()->associate($sale);
                $d->save();

            }
        }

        $promotionsNew = $request->input('promotionsNew');
        if (is_array($promotionsNew) ){
            foreach($promotionsNew as $promotionId)
            {
                $promotion = Promotion::findOrFail($promotionId['id']);
                $d = new SaleDetail();
                $d->amount = $promotionId['amount'];
                $d->price = $promotionId['price'];
                $d->promotion()->associate($promotion);
                $d->sale()->associate($sale);
                $d->save();

            }
        }

        $sale->save();
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
        $product = Sale::findOrFail($id);
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
        $sales = DB::table('sales') ->select('sales.id', 'sales.client', 'sales.orderDateTime' , 'sales.deliveryDateTime')->where('sales.isDeleted', '=', 0)->get();

        //Formatea las fechas
        foreach($sales as $sale){
            $formato = 'Y-m-d H:i:s';
            $delivery =DateTime::createFromFormat($formato, $sale->deliveryDateTime);
            $order =DateTime::createFromFormat($formato, $sale->orderDateTime);
            $sale->orderDateTime=  $order->format('d/m/Y H:i');
            $sale->deliveryDateTime=  $delivery->format('d/m/Y H:i');
        }

        

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
        $sale_details = DB::table('sale_details')->leftJoin('products', 'products.id', '=', 'sale_details.product_id')->leftJoin('product_types', 'products.product_type_id', '=', 'product_types.id')->leftJoin('promotions', 'promotions.id', '=', 'sale_details.promotion_id')->select('sale_details.id', 'sale_details.amount', 'sale_details.price', 'products.name as productName', 'promotions.name as promotionName', 'product_types.name as typeProduct')->where('sale_details.sale_id', '=', $request->input('id'))->where('sale_details.isDeleted', '=', 0)->get();

        return response()->json(['success' => true, 'data' => $sale_details]);

    }

}
