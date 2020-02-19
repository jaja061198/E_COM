@php
    use App\Helper\Helper;
    use App\Http\Controllers\OrdersController;
@endphp
@extends('layout')

@section('title', 'My Orders')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Orders</span>
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
              <li><a href="{{ route('users.shipping.edit') }}">Shipping Information</a></li>
              <li class="active"><a href="{{ route('orders.index') }}">Pending Orders</a> <font style="color: red;">({{ OrdersController::countOrders(0) }})</font></li>
              <li><a href="{{ route('payment.index') }}">For Payment</a> <font style="color: red;">({{ OrdersController::countOrders(2) }})</font></li>
              <li><a href="{{ route('orders.pickup') }}">For Store Pickup</a> <font style="color: red;">({{ OrdersController::countOrders(4) }})</font></li>
              <li><a href="{{ route('orders.shipping') }}">For Shipping</a> <font style="color: red;">({{ OrdersController::countOrders(6) }})</font></li>
              <li><a href="{{ route('orders.received') }}">To Receive</a> <font style="color: red;">({{ OrdersController::countOrders(5) }})</font></li>
              <li><a href="{{ route('orders.complete') }}">Completed</a> <font style="color: red;">({{ OrdersController::countOrders(7) }})</font></li>
              <li><a href="{{ route('orders.cancel') }}">Cancelled Order</a> <font style="color: red;">({{ OrdersController::countOrders(1) }})</font></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Orders</h1>
            </div>

            <div>
                @foreach ($orders as $order)
                <div class="order-container">
                    <div class="order-header">
                        <div class="order-header-items">
                            <div>
                                <div class="uppercase font-bold">No. of items</div>
                                <div>{{ Helper::getOrderQuant($order['order_no']) }}</div>
                            </div>
                            <div>
                                <div class="uppercase font-bold">Order ID</div>
                                <div>{{ $order['order_no'] }}</div>
                            </div><div>
                                <div class="uppercase font-bold">Total</div>
                                <div>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order['order_no'])) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="order-header-items">
                                <div><a href="{{ route('orders.show',['order' => str_replace("#","w",$order->order_no)]) }}">Order Details</a></div>
                                <div>|</div>
                                <div><b style="color:red;">PENDING</b></div>
                                {{-- <div><a href="#">Invoice</a></div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <div class="order-products">
                        @foreach ($order->products as $product)
                            <div class="order-product-item">
                                <div><img src="" alt="Product Image"></div>
                                <div>
                                    <div>
                                        <a href="w">ww</a>
                                    </div>
                                    <div>#</div>
                                    <div>Quantity: #</div>
                                </div>
                            </div>
                        @endforeach

                    </div> --}}
                </div> <!-- end order-container -->
                @endforeach
            </div>

            <div class="spacer"></div>
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
