<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Input;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Models\OrderHeader as OrderHeaderModel;
use App\Http\Models\OrderDetail as OrderDetailModel;
use App\Http\Models\Cart as CartModel;
use App\OrderLog as OrderLogModel;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = auth()->user()->orders; // n + 1 issues

        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=','2')->orWhere('status','=','3')->get();

        return view('my-order-payment')->with([
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

    $extension = Input::file('add_item_image')->getClientOriginalExtension();
    $filename_old = Input::file('add_item_image')->getClientOriginalName();
    $filesize = Input::file('add_item_image')->getClientSize();

    $filename = rand(11111111, 99999999). '.' . $extension;
    $fullPath = $filename;

    $order_details = [
        'status' => '3',
        'image' => $fullPath,
    ];

    OrderHeaderModel::where('order_no','=',$request->input('code'))->update($order_details);

    $request->file('add_item_image')->move(base_path('public/img/'), $filename);

    $order_log = [
        'order_no' => $request->input('code'),
        'action' => 'Payment has been submitted for review',
    ];

    OrderLogModel::insert($order_log);

    return back()->with('success_message', 'Item is already in your cart!');

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
