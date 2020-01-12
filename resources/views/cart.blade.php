@php
    use App\Helper\Helper;
@endphp
@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="#">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>Shopping Cart</span>
    @endcomponent

    <div class="cart-section container">

        <div>
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

            @if ($counter > 0)

            <h2>{{ $counter }} item(s) in Shopping Cart</h2>
            
            @php
                $total = 0;
            @endphp
            <form action="{{ route('cart.update') }}" method="post">
                {{ csrf_field() }}
                <div class="cart-table">
                    @foreach ($cart_items as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <input type="hidden" name="get_code[]" value="{{ $item->item_code }}">
                            <a href="{{ route('shop.show', $item->item_code) }}"><img src="{{ Helper::getImageBase()->link }}{{ Helper::getItemDetails($item->item_code)->IMAGE }}" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a href="{{ route('shop.show', $item->item_code) }}">{{ Helper::getItemDetails($item->item_code)->ITEM_DESC }}</a></div>
                                <div class="cart-table-description">{{ Helper::getItemDetails($item->item_code)->getBrand->BRAND_DESC}} - {{ Helper::getItemDetails($item->item_code)->getType->ITEM_TYPE_DESC}}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                {{-- <form action="{{ route('cart.destroy', $item->item_code) }}" method="POST"> --}}
                                    <a href="{{ route('cart.destroy',['product' => $item->item_code]) }}" class="cart-options">Remove</a>
                            </div>
                            <div>
                                {{-- <select class="quantity" data-id="{{ $item->item_code }}" data-productQuantity="{{ $item->quantity }}">
                                    @for ($i = 1; $i < 5 + 1 ; $i++)
                                        <option {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select> --}}
                                <input type="number" name="quantity[]" min="1" value="{{ $item->quantity }}" style="width: 50px;">
                                 <input type="hidden" name="old_quantity[]" min="1" value="{{ $item->quantity }}" style="width: 50px;">
                                <input type="hidden" name="price[]" value="{{ Helper::getItemDetails($item->item_code)->STANDARD_PRICE }}">
                            </div>
                            <div>PHP {{ Helper::numberFormat(Helper::getItemDetails($item->item_code)->STANDARD_PRICE * $item->quantity) }}</div>
                            @php
                                $total += Helper::getItemDetails($item->item_code)->STANDARD_PRICE * $item->quantity;
                            @endphp
                        </div>
                    </div> <!-- end cart-table-row -->
                    @endforeach
                

                <div class="cart-totals">
                    <div class="cart-totals-left">
                        
                    </div>

                    <div class="cart-totals-right">
                        <div>
                            Retrieving <br>
                            @if($ship_type == '1')
                            Shipping Fee <br>
                            @endif
                            Subtotal <br>
                            {{-- Tax (12%)<br> --}}
                            <span class="cart-totals-total">Total</span>
                        </div>
                        <div class="cart-totals-subtotal">
                            
                                <select onchange="submitShipping(this.value)">
                                    <option value="2" @if($ship_type == '2') selected @endif>Store Pick Up</option>
                                    <option value="1" @if($ship_type == '1') selected @endif>Ship</option>
                                </select>
                            
                            <br>
                            @if($ship_type == '1')
                            {{-- shipping fee --}}
                            {{ Helper::numberFormat($shipping_fee) }} <br>
                            @endif
                            PHP {{ Helper::numberFormat($total) }} <br>
                            {{-- tax --}}
                            {{-- PHP {{ Helper::numberFormat($total * .12)  }} <br> --}}
                            <span class="cart-totals-total">PHP {{ Helper::numberFormat($total + $shipping_fee) }}</span>
                        </div>
                    </div>
                </div> <!-- end cart-totals -->


                <div class="cart-buttons">
                    <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                    <button type="submit" class="button">Update Cart</button>
                    <a href="{{ route('checkout.index') }}" class="button-primary">Submit Order</a>
                </div>

                </div> <!-- end cart-table -->
            </form>
            
            <form method="post" action="{{ route('cart.ship') }}" id="shipping_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ship" value="" id="ship">
            </form>
            @else

                <h3>No items in Cart!</h3>
                <div class="spacer"></div>
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <div class="spacer"></div>

            @endif
        </div>

    </div> <!-- end cart-section -->

    @include('partials.might-like')


@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id = element.getAttribute('data-id')
                    const productQuantity = element.getAttribute('data-productQuantity')

                    axios.patch(`/cart/${id}`, {
                        quantity: this.value,
                        productQuantity: productQuantity
                    })
                    .then(function (response) {
                        // console.log(response);
                        window.location.href = '{{ route('cart.index') }}'
                    })
                    .catch(function (error) {
                        // console.log(error);
                        window.location.href = '{{ route('cart.index') }}'
                    });
                })
            })
        })();

    function submitShipping(ship_value)
    {
        document.getElementById('ship').value = ship_value;
        document.getElementById("shipping_form").submit();
    }
    </script>

    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
