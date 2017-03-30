<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotion;
use App\PromotionDetail;
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
        return response()->json( Promotion::all() );
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $p = new Promotion();
        $p->name = $request->input('name');
        $p->price = $request->input('price');
        $p->save();
        /**VER COMO RECORRER TODOS LOS DETALLES
        $d = new PromotionDetail();
        $d->amount = $request->input('amount');
        $d->product()->associate($request->input('product'));
        $d->promotion()->associate($p);
        $d->save();**/
        return response()->json( ['error' => false,'msg' => 'La promoción se ha guardado exitosamente!' ] );
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
      /**VER COMO RECORRER TODOS LOS DETALLES
      $d = new PromotionDetail();
      $d->amount = $request->input('amount');
      $d->product()->associate($request->input('product'));
      $d->promotion()->associate($p);
      $d->save();**/
      return response()->json( ['error' => false,'msg' => 'La promoción ha sido modificada exitosamente!' ] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $p = Promotion::findOrFail($id);
      $p->isDeleted = true;
      return response()->json( ['error' => false,'msg' => 'La promoción fue eliminada exitosamente!' ] );
    }
}
