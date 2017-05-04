<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Stock;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return View('stock.stock');
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
     * Display stock list.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showStock()
    {
        $stocks = DB::table('stocks')->join('ingredients', 'ingredients.id', '=', 'stocks.ingredient_id') ->select('stocks.ingredient_id', 'stocks.amount', 'ingredients.name AS name')->get();

        return response()->json(['success' => true, 'data' => $stocks]);
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
        $this->validate($request, [
            'amount' => 'required| numeric',
        ]);

        $stock = Stock::findOrFail($id);
        $stock->amount = $request->input('amount');
        $stock->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {

       $stockUpdate = $request->input('stockUpdate');

        if (is_array($stockUpdate) ){
            foreach($stockUpdate as $stock)
            {
                $currentStock = Stock::findOrFail($stock['id']);
                $currentStock->amount = $stock['amount'];
                $currentStock->save();

            }
        }
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


}
