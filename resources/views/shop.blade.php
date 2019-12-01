@php
    use App\Helper\Helper;
@endphp
@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shop</span>
    @endcomponent

    <div class="container">
        @if (session()->has('success_message'))
            <div class="alert alert-success">
                {{ session()->get('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Type</h3>
            <ul>
                {{-- @foreach ($categories as $category)
                    <li class="{{ setActiveCategory($category->slug) }}"><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach --}}
                @foreach ($types as $category)
                    <li class=""><a href="">{{ $category->ITEM_TYPE_DESC }}</a></li>
                @endforeach
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">Product List</h1>
                <div>
                    <strong>Price: </strong>
                    {{-- <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'low_high']) }}">Low to High</a> |
                    <a href="{{ route('shop.index', ['category'=> request()->category, 'sort' => 'high_low']) }}">High to Low</a> --}}

                    <a href="">Low to High</a> |
                    <a href="">High to Low</a>

                </div>
            </div>

            <div class="products text-center">
                @forelse ($items as $product)
                    <div class="product">
                        <a href=""><img src="http://localhost:8000/{{ $product['IMAGE'] }}" alt="product"></a>
                        <a href="{{ route('shop.show',['products' => $product->ITEM_CODE]) }}"><div class="product-name">{{ $product->ITEM_DESC }}</div></a>
                        <div class="product-price">PHP {{ Helper::numberFormat($product['STANDARD_COST']) }}</div>
                    </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse
            </div> <!-- end products -->

            <div class="spacer"></div>
            {{-- {{ $products->appends(request()->input())->links() }} --}}
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
