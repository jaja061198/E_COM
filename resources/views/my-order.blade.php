@php
    use App\Helper\Helper;
@endphp
@extends('layout')

@section('title', 'My Order')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Order</span>
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

    <div class="products-section my-orders container">
        <div class="sidebar">

            <ul>
              <li><a href="{{ route('users.edit') }}">My Profile</a></li>
              <li class="active"><a href="{{ route('orders.index') }}">My Orders</a></li>
              <li><a href="{{ route('orders.index') }}">For Payment</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">Order ID: {{ $order->order_no }}</h1>
            </div>

            <div>
                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                <div class="uppercase font-bold">Order Placed</div>
                                <div>{{ $order->date_ordered }}</div>
                            </div>
                            <div>
                                <div class="uppercase font-bold">Order ID</div>
                                <div>{{ $order->order_no }}</div>
                            </div><div>
                                <div class="uppercase font-bold">Total</div>
                                <div>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no) + (Helper::sumOfOrder($order->order_no) * .12)) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="order-header-items">
                                <div><a href="#" style="color:red;">PENDING</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="order-products">
                        <table class="table" style="width:50%">
                            <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ Helper::getUserDetails($order->user)->name }}</td>
                                </tr>
                                {{-- <tr>
                                    <td>Address</td>
                                    <td>detailll</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>cityzxczxc</td>
                                </tr> --}}
                                <tr>
                                    <td>Subtotal</td>
                                    <td>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no)) }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no) * .12) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no) + (Helper::sumOfOrder($order->order_no) * .12)) }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div> <!-- end order-container -->

                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                Order Items
                            </div>

                        </div>
                    </div>
                    <div class="order-products">
                        @foreach ($products as $product)

                            <div class="order-product-item">
                                <div><img src="{{ Helper::getImageBase()->link }}{{ Helper::getItemDetails($product->item_code)->IMAGE }}" alt="Product Image"></div>
                                <div>
                                    <div>
                                        <a href="{{ route('shop.show', $product->item_code) }}">{{ Helper::getItemDetails($product->item_code)->ITEM_DESC }}</a>
                                    </div>
                                    <div>{{ Helper::numberFormat(Helper::getItemDetails($product->item_code)->STANDARD_PRICE) }}</div>
                                    <div>Quantity: {{ $product->quantity }}</div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div> <!-- end order-container -->
            </div>

            <div class="spacer"></div>

            <div class="cart-buttons">
                    <a href="{{ route('shop.index') }}" class="button">Cancel Order</a>
            </div>
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
