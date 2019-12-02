@php
    use App\Helper\Helper;
    use App\Http\Models\Item;
@endphp
@extends('layout')

@section('title',$product->ITEM_DESC)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span><a href="{{ route('shop.index') }}">Shop</a></span>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>{{ $product->ITEM_DESC }}</span>
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

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{ Helper::getImageBase()->link }}{{ $product->IMAGE }}" alt="product" class="active" id="currentImage">
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ Helper::getImageBase()->link }}{{ $product->IMAGE }}" alt="product">
                </div>

                {{-- @if ($product->IMAGE)
                    @foreach (json_decode($product->IMAGE, true) as $image)
                    <div class="product-section-thumbnail">
                        <img src="http://localhost:8000/{{ $product->IMAGE }}" alt="product">
                    </div>
                    @endforeach
                @endif --}}
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{ $product->ITEM_DESC }}</h1>
            <div class="product-section-subtitle">{{ $product->getType->ITEM_TYPE_DESC }} - {{ $product->getBrand->BRAND_DESC }}</div>
            <div>
                @if($product->QUANTITY > 0)
                    <div class="badge badge-success">In Stock</div>
                @else
                    <div class="badge badge-danger">Not available</div>
                @endif
            </div>
            <div class="product-section-price">PHP {{ Helper::numberFormat($product['STANDARD_PRICE']) }}</div>

            <p>
                {{ $product->DESCRIPTION }}
            </p>

            <p>&nbsp;</p>

            @if(Auth::check())

                @if ($product->QUANTITY > 0)
                    <form action="{{ route('cart.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="item" value="{{ $product->ITEM_CODE }}">
                        <button type="submit" class="button button-plain">Add to Cart</button>
                    </form>
                @endif

            @else
                    <a href="{{ route('login') }}"><button type="button" class="button button-plain">Please Login to Continue</button></a>
            @endif
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')

@endsection

@section('extra-js')
    <script>
        (function(){
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail');

            images.forEach((element) => element.addEventListener('click', thumbnailClick));

            function thumbnailClick(e) {
                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                })

                images.forEach((element) => element.classList.remove('selected'));
                this.classList.add('selected');
            }

        })();
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>

@endsection
