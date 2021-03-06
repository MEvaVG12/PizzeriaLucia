<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Promotion;
use App\PromotionDetail;
use App\Product;

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

        $promotionsNew = $request->input('promotionsNew');
        if (is_array($promotionsNew) ){
            foreach($promotionsNew as $currentPromotion)
            {
                $product = Product::findOrFail($currentPromotion['id']);
                $d = new PromotionDetail();
                $d->amount = $currentPromotion['amount'];
                $d->product()->associate($product);
                $d->promotion()->associate($promotion);
                $d->save();

            }
        }

        $promotionsUpdate = $request->input('promotionsUpdate');
        if (is_array($promotionsUpdate) ){
            foreach($promotionsUpdate as $currentPromotion)
            {
                $promotionDetail = PromotionDetail::find($currentPromotion['id']);
                if (!empty($promotionDetail)){
                    $promotionDetail->amount = $currentPromotion['newValue'];
                    $promotionDetail->save();
                 }
            }
        }

        $promotionsDelete = $request->input('promotionsDelete');
        if (is_array($promotionsDelete) ){
            foreach($promotionsDelete as $currentPromotion)
            {
                $promotionDetail = PromotionDetail::find($currentPromotion['id']);
                if (!empty($promotionDetail)){
                    $promotionDetail->delete();
                }
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
        $promotion_details = DB::table('promotion_details')->join('products', 'products.id', '=', 'promotion_details.product_id')->join('product_types', 'products.product_type_id', '=', 'product_types.id') ->select('promotion_details.id', 'promotion_details.amount', 'products.name as productName', 'product_types.name as typeProduct')->where('promotion_details.promotion_id', '=', $request->input('id'))->get();

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
