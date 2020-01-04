<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Models\ItemType as ItemTypeModel;
use App\Http\Models\Item as ItemModel;
use App\Http\Models\Terms as TermsModel;

class TermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('terms')
        ->with('items',TermsModel::first());
    }


}
