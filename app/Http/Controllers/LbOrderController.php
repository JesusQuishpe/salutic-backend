<?php

namespace App\Http\Controllers;

use App\Models\LbOrder;
use App\Models\LbOrderTest;
use Illuminate\Http\Request;

class LbOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('pending') && $request->has('identification')){
            $model=new LbOrder();
            $orders=$model->pendingOrdersByIdentification($request->input('identification'));
            return response()->json($orders);
        }

        if($request->has('identification')){
            $model=new LbOrder();
            $orders=$model->currentOrderByIdentification($request->input('identification'));
            return response()->json($orders);
        }
        return response()->json(LbOrder::all());
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
     * @param  \App\Models\LbOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function show(LbOrder $order)
    {
        $tests=LbOrderTest::with('test')->where('order_id','=',$order->id)->get();
        $order->tests=$tests;
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LbOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LbOrder $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LbOrder  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(LbOrder $order)
    {
        //
    }
}
