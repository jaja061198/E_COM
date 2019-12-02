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

        $cart_counter = CartModel::where('user_id','=',Auth::user()->id)->sum('quantity');

        return view('cart')->with([
            'mightAlsoLike' => $mightAlsoLike,
            'cart_items' => $cart_count,
            'counter' => $cart_counter,
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
        $duplicates = CartModel::where('item_code','=',$request->input('item'))->where('user_id','=',Auth::user()->id)->count();

        if ($duplicates > 0) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in your cart!');
        }

        $cart = [
            'user_id' => Auth::user()->id,
            'item_code' => $request->input('item'),
            'quantity' => 1,
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
}
