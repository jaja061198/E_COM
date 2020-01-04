<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Models\ItemType as ItemTypeModel;
use App\Http\Models\Item as ItemModel;
use App\Http\Models\About as AboutModel;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('abouts-us')
        ->with('items',AboutModel::first());
    }


}
