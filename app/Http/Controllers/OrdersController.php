<?php

namespace App\Http\Controllers;

use Auth;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Models\OrderHeader as OrderHeaderModel;
use App\Http\Models\OrderDetail as OrderDetailModel;
use App\Http\Models\Cart as CartModel;
use App\OrderLog as OrderLogModel;

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

        $order_log = OrderLogModel::where('order_no','=',str_replace('w', '#', $order->order_no))->orderBy('date_performed','DESC')->get();

        if (Auth::user()->id != $order->user) 
        {
             return back()->withErrors('You do not have access to this!');
        }


        return view('my-order')->with([
            'order' => $order,
            'products' => $products,
            'logs' => $order_log,
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
    public function shipping()
    {
        //
        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',6)->get();

        return view('my-orders-shipping')->with([
            'orders' => $orders,
        ]);

    }

    public function received()
    {
        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',5)->get();

        return view('my-orders-received')->with([
            'orders' => $orders,
        ]);
    }

    public function pickup()
    {
        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',4)->get();

        return view('my-orders-pickup')->with([
            'orders' => $orders,
        ]);
    }

    public function complete()
    {
        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',7)->get();

        return view('my-orders-completed')->with([
            'orders' => $orders,
        ]);
    }

    public function cancel()
    {
        $orders = OrderHeaderModel::where('user','=',Auth::user()->id)->where('status','=',1)->get();

        return view('my-orders-cancel')->with([
            'orders' => $orders,
        ]);
    }

    public function changeStatus($id , $action)
    {
        OrderHeaderModel::where('order_no','=',str_replace('w', '#', $id))->update(['status' => $action]);

        if ($action == '1') 
        {
            $order_log = [
                'order_no' => str_replace('w', '#', $id),
                'action' => 'Order has been cancelled by the user',
            ];

            OrderLogModel::insert($order_log);

            return back()->with('success_message', 'Order has been cancelled !');
        }
        $order_log = [
            'order_no' => str_replace('w', '#', $id),
            'action' => 'Order has been received and completed',
        ];

        OrderLogModel::insert($order_log);

        return back()->with('success_message', 'Order Complete !');
    }

    public static function countOrders($status)
    {
        if ($status == '2' || $status == '3') {
            return OrderHeaderModel::where('status','=','2')->orWhere('status','=','3')->count();
        }
        return OrderHeaderModel::where('status','=',$status)->count();
    }
}
