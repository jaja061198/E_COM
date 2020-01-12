<?php

namespace App\Http\Controllers;

use Auth;
use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\ItemType as ItemTypeModel;
use App\Http\Models\Item as ItemModel;
use App\Http\Models\Cart as CartModel;
use App\Shipping as ShippingModel;
use App\User as UserModel;
use App\OrderLog as OrderLogModel;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = ItemModel::all()->random(4);

        $cart_count = CartModel::where('user_id','=',Auth::user()->id)->get();

        $ship_type = CartModel::where('user_id','=',Auth::user()->id)->where('ship_type','=','1')->count();

        $cart_counter = CartModel::where('user_id','=',Auth::user()->id)->sum('quantity');

        $ship_id = '2';

        $ship_value = 0;

        if ($ship_type > 0) 
        {
            $ship_type_id = CartModel::where('user_id','=',Auth::user()->id)->where('ship_type','=','1')->first();

            $ship_details = ShippingModel::where('id','=',$ship_type_id->ship_type)->first();

            $ship_id = $ship_type_id->ship_type;

            $ship_value = $ship_details['price'];

        }

        return view('cart')->with([
            'mightAlsoLike' => $mightAlsoLike,
            'cart_items' => $cart_count,
            'counter' => $cart_counter,
            'shipping_fee' => $ship_value,
            'ship_type' => $ship_id,
            'ship_counter' => $ship_type,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $check_address = UserModel::where('id','=',Auth::user()->id)->first();

        if ($check_address->area == null || $check_address->area == 0) 
        {
            # code...
            return redirect()->route('users.edit')->withErrors('Please Set up your shipping information first');
        }
        $duplicates = CartModel::where('item_code','=',$request->input('item'))->where('user_id','=',Auth::user()->id)->count();

        if ($duplicates > 0) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your cart!');
        }

        $cart = [
            'user_id' => Auth::user()->id,
            'item_code' => $request->input('item'),
            'quantity' => 1,
            'ship_type' => '1',
        ];

        CartModel::insert($cart);

        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->input('get_code') as $key => $value) 
        {
            $quantity = [
                'quantity' => $request->input('quantity')[$key],
            ];

            CartModel::where('item_code','=',$request->input('get_code')[$key])
                    ->where('user_id','=',Auth::user()->id)
                    ->update($quantity);
        }
        // return $request->all();
        // $validator = Validator::make($request->all(), [
        //     'quantity' => 'required|numeric|between:1,5'
        // ]);

        // if ($validator->fails()) {
        //     session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
        //     return response()->json(['success' => false], 400);
        // }

        // if ($request->quantity > $request->productQuantity) {
        //     session()->flash('errors', collect(['We currently do not have enough items in stock.']));
        //     return response()->json(['success' => false], 400);
        // }

        // Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Cart was updated successfully!');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CartModel::where('item_code','=',$id)->where('user_id','=',Auth::user()->id)->delete();

        return back()->with('success_message', 'Item has been removed!');
    }

    /**
     * Switch item for shopping cart to Save for Later.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToSaveForLater($id)
    {
        $item = Cart::get($id);

        Cart::remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already Saved For Later!');
        }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item has been Saved For Later!');
    }

    public function shipping(Request $request)
    {
        CartModel::where('user_id','=',Auth::user()->id)->update(['ship_type' => $request->input('ship')]);

        return back()->with('success_message', 'Item has been removed!');
    }
}
