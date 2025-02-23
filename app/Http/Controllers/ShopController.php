<?php

namespace App\Http\Controllers;

use Session;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Models\ItemType as ItemTypeModel;
use App\Http\Models\Item as ItemModel;
use App\Http\Models\Services as ServiceModel;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function serviceIndex()
    {
        return view('services')
        ->with([
            'items' => ServiceModel::all(),
        ]);
    }

    public function filterIndex($filter)
    {
        if($filter == 'low')
        {
            return view('services')
            ->with([
                'items' => ServiceModel::orderBy('STANDARD_COST','ASC')->get(),
            ]);
        }

        if($filter == 'high')
        {
            return view('services')
            ->with([
                'items' => ServiceModel::orderBy('STANDARD_COST','DESC')->get(),
            ]);
        }
        
    }

    public function index()
    {
        return view('shop')
        ->with([
            'types' => ItemTypeModel::all(),
            'items' => ItemModel::where('STATUS','=','1')->get(),
        ]);
        $pagination = 9;
        $categories = Category::all();

        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        } else {
            $products = Product::where('featured', true);
            $categoryName = 'Featured';
        }

        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate($pagination);
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc')->paginate($pagination);
        } else {
            $products = $products->paginate($pagination);
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $products = ItemModel::where('ITEM_CODE','=',$slug)->first();

        if (empty($products) || $products->STATUS == '2') 
        {
            # code...

            return back()->withErrors('Item Not found!');
        }

        $mightAlsoLike = ItemModel::where('ITEM_TYPE','=',$products->ITEM_TYPE)->where('ITEM_CODE','!=',$products->ITEM_CODE)->get();

        return view('product')->with([
            'product' => $products,

            'mightAlsoLike' => $mightAlsoLike,
        ]);
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

        $stockLevel = getStockLevel($product->quantity);

        return view('product')->with([
            'product' => $product,
            'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        // $products = Product::where('name', 'like', "%$query%")
        //                    ->orWhere('details', 'like', "%$query%")
        //                    ->orWhere('description', 'like', "%$query%")
        //                    ->paginate(10);

        $products = Product::search($query)->paginate(10);

        return view('search-results')->with('products', $products);
    }

    public function searchAlgolia(Request $request)
    {
        return view('search-results-algolia');
    }
}
