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
        return response()->json(Product::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('catalog.edit', array('product'=>response()->json(Product::findOrFail($id))));
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
      $d = PromotionDetail::where('promotion_id', $id);
      $d->delete();

      $p = Promotion::findOrFail($id);
      $p->name = $request->input('name');
      $p->price = $request->input('price');
      $p->save();

      return response()->json( ['error' => false,'msg' => 'La promoción ha sido modificada exitosamente!' ] );
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

}
