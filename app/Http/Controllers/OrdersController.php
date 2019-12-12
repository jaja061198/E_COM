<?php

namespace App\Http\Controllers;

use Auth;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Models\OrderHeader as OrderHeaderModel;
use App\Http\Models\OrderDetail as OrderDetailModel;
use App\Http\Models\Cart as CartModel;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = auth()->user()->orders; // n + 1 issues

        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',0)->get();

        return view('my-orders')->with([
            'orders' => $orders,
        ]);
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
    public function show($order)
    {   

        $order = OrderHeaderModel::where('order_no','=',str_replace('w', '#', $order))->first();

        $products = OrderDetailModel::where('order_id','=',$order->order_no)->get();

        if (Auth::user()->id != $order->user) 
        {
             return back()->withErrors('You do not have access to this!');
        }


        return view('my-order')->with([
            'order' => $order,
            'products' => $products,
        ]);
        // if (auth()->id() !== $order->user_id) {
        //     return back()->withErrors('You do not have access to this!');
        // }

        // $products = $order->products;

        // return view('my-order')->with([
        //     'order' => $order,
        //     'products' => $products,
        // ]);
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
}
