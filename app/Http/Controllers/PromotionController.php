<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Promotion;
use App\PromotionDetail;
use App\Product;
use Notification;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View('promotion.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('promotion.create');
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
            'name' => 'required|unique:promotions',
            'price' => 'required',
            'productsId' => 'required',
            'amounts' => 'required',
        ]);

        $p = new Promotion();
        $p->name = $request->input('name');
        $p->price = $request->input('price');
        $p->save();

        $productsId = $request->input('productsId');
        $amounts = $request->input('amounts');

        $i= 0;
        if (is_array($productsId) )
        {
            foreach($productsId as $productId)
            {
                $product = Product::findOrFail($productId);
                $d = new PromotionDetail();
                $d->amount = $amounts[$i];
                $d->product()->associate($product);
                $d->promotion()->associate($p);
                $d->save();
                $i++;
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
        $this->validate($request, [
            'price' => 'required'
        ]);

        $promotion = Promotion::findOrFail($id);
        $promotion->price = $request->input('price');

        $productsUpdate = $request->input('productsUpdate');
        if (is_array($productsUpdate) ){
            foreach($productsUpdate as $productId)
            {
                $promotionDetail = PromotionDetail::findOrFail($productId['id']);
                $promotionDetail->amount = $productId['newValue'];
                $promotionDetail->save();
            }
        }

        $productsDelete = $request->input('productsDelete');
        if (is_array($productsDelete) ){
            foreach($productsDelete as $productId)
            {
                $promotionDetail = PromotionDetail::findOrFail($productId['id']);
                $promotionDetail->delete();
            }
        }

        $productsNew = $request->input('productsNew');
        if (is_array($productsNew) ){
            foreach($productsNew as $productId)
            {
                $product = Product::findOrFail($productId['id']);
                $d = new PromotionDetail();
                $d->amount = $productId['amount'];
                $d->product()->associate($product);
                $d->promotion()->associate($promotion);
                $d->save();

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
