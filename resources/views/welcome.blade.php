@php

use App\Http\Models\Item;
use App\Http\Models\Services;
use App\Helper\Helper;
@endphp
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Oculus</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:300,400,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">

    </head>
    <body>
        <div id="app">
            <header class="with-background">
                <div class="top-nav container">
                    <div class="top-nav-left">
                        <div class="logo">Oculus</div>
                        {{-- {{ menu('main', 'partials.menus.main') }} --}}
                    </div>
                    <div class="top-nav-right">
                        @include('partials.menus.main-right')
                    </div>
                </div> <!-- end top-nav -->
                <div class="hero container">
                    <div class="hero-copy">
                        <h1>{!! Helper::getHeaderText()->welcome_greet !!}</h1>
                        <p>{!! Helper::getHeaderText()->welcome_msg !!}</p>
                        <div class="hero-buttons">
                            <a href="{{ route('about.us') }}" class="button button-white">About Us</a>
                        </div>
                    </div> <!-- end hero-copy -->

                    <div class="hero-image">
                        <img src="{{ Helper::getImageBase()->link }}{{ Helper::getHeaderText()->img }}" alt="hero image">
                    </div> <!-- end hero-image -->
                </div> <!-- end hero -->
            </header>

            <div class="featured-section">

                <div class="container">
                    <h1 class="text-center">Our Items</h1>

                    {{-- <p class="section-description">Choose from our wide range of CAR components.</p> --}}

                   {{--  <div class="text-center button-container">
                        <a href="#" class="button">Featured</a>
                        <a href="#" class="button">On Sale</a>
                    </div> --}}

                    {{-- <div class="tabs">
                        <div class="tab">
                            Featured
                        </div>
                        <div class="tab">
                            On Sale
                        </div>
                    </div> --}}

                    <div class="products text-center">

                        

                        @foreach (Item::getItems() as $key => $value)
                            <div class="product">
                                <a href="{{ route('shop.show',['products' => $value->ITEM_CODE]) }}"><img src="
                                    {{ Helper::getImageBase()->link }}{{ $value['IMAGE'] }}" alt="product"></a>
                                <a href="{{ route('shop.show',['products' => $value->ITEM_CODE]) }}"><div class="product-name">{{ $value['ITEM_DESC'] }}</div></a>
                                <div class="product-price">PHP {{ Helper::numberFormat($value['STANDARD_PRICE']) }}</div>
                            </div>
                        @endforeach
                        {{-- @foreach ($products as $product)
                            <div class="product">
                                <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ productImage($product->image) }}" alt="product"></a>
                                <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                                <div class="product-price">{{ $product->presentPrice() }}</div>
                            </div>
                        @endforeach --}}

                    </div> <!-- end products -->

                    <div class="text-center button-container">
                        <a href="{{ route('shop.index') }}" class="button">View more products</a>
                    </div>

                </div> <!-- end container -->


                {{-- Services --}}


                <div class="featured-section">

                <div class="container">
                    <h1 class="text-center">Our Services</h1>

                    {{-- <p class="section-description">Choose from our wide range of CAR components.</p> --}}

                   {{--  <div class="text-center button-container">
                        <a href="#" class="button">Featured</a>
                        <a href="#" class="button">On Sale</a>
                    </div> --}}

                    {{-- <div class="tabs">
                        <div class="tab">
                            Featured
                        </div>
                        <div class="tab">
                            On Sale
                        </div>
                    </div> --}}

                    <div class="products text-center">

                        

                        @foreach (Services::getServices() as $key => $value)
                            <div class="product">
                                <a href="#" style="pointer-events: none;"><img src="
                                    {{ Helper::getImageBase()->link }}img/13430259.jfif" alt="product"></a>
                                <a href="#" style="pointer-events: none;"><div class="product-name">{{ $value['SERVICE_DESC'] }}</div></a>
                                <div class="product-price">PRICE STARTS AT <br>PHP {{ Helper::numberFormat($value['STANDARD_COST']) }}</div>
                            </div>
                        @endforeach
                        {{-- @foreach ($products as $product)
                            <div class="product">
                                <a href="{{ route('shop.show', $product->slug) }}"><img src="{{ productImage($product->image) }}" alt="product"></a>
                                <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                                <div class="product-price">{{ $product->presentPrice() }}</div>
                            </div>
                        @endforeach --}}

                    </div> <!-- end products -->

                    <div class="text-center button-container">
                        <a href="{{ route('services.index') }}" class="button">View more services</a>
                    </div>

                </div> <!-- end container -->


            </div> <!-- end featured-section -->

            {{-- <blog-posts></blog-posts> --}}

            @include('partials.footer')

        </div> <!-- end #app -->
        <script src="js/app.js"></script>

        <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    </body>
</html>
