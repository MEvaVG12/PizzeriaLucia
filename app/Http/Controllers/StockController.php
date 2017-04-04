<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use DB;
use Notification;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::all()->take(10);
        return View('stock/info')->with('stocks',$stocks);
        //return response()->json( Stock::all() );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listall(){
        $stocks = Stock::
        select('stocks.id','stocks.amount', 'ingredients.name as ingredient')
            ->join('ingredients','ingredients.id','=','stocks.ingredient_id')
            ->take(10);
        return View('stock/info')->with('stocks',$stocks);
        //return View('stock/listall')->with('stocks',$stocks);
    }


    public function getJoinsData()
    {

        return $posts = DB::table('stocks')->join('ingredients', 'ingredients.id', '=', 'stocks.ingredient_id')
            ->select(['stocks.amount', 'ingredients.name']);

    }

}
