@php
    use App\Helper\Helper;
    use App\Http\Controllers\OrdersController;
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
              <li><a href="{{ route('orders.index') }}">Pending Orders</a> <font style="color: red;">({{ OrdersController::countOrders(0) }})</font></li>
              <li><a href="{{ route('payment.index') }}">For Payment</a> <font style="color: red;">({{ OrdersController::countOrders(2) }})</font></li>
              <li><a href="{{ route('orders.pickup') }}">For Store Pickup</a> <font style="color: red;">({{ OrdersController::countOrders(4) }})</font></li>
              <li><a href="{{ route('orders.shipping') }}">For Shipping</a> <font style="color: red;">({{ OrdersController::countOrders(6) }})</font></li>
              <li><a href="{{ route('orders.received') }}">To Receive</a> <font style="color: red;">({{ OrdersController::countOrders(5) }})</font></li>
              <li><a href="{{ route('orders.complete') }}">Completed</a> <font style="color: red;">({{ OrdersController::countOrders(7) }})</font></li>
              <li><a href="{{ route('orders.cancel') }}">Cancelled Order</a> <font style="color: red;">({{ OrdersController::countOrders(1) }})</font></li>
              <li class="active"><a href="#}">Order Detail</a></li>
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
                                <div>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no) + $order->shipping_price) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="order-header-items">
                                <div>
                                    @if($order->status == 0)
                                        <a href="#" style="color:red;">PENDING</a>
                                    @endif

                                    @if($order->status == 1)
                                        <a href="#" style="color:red;">Cancelled</a>
                                    @endif

                                    @if($order->status == 2)
                                        <a href="#" style="color:red;">Waiting for Payment</a>
                                    @endif

                                    @if($order->status == 3)
                                        <a href="#" style="color:red;">For Payment Review</a>
                                    @endif

                                    @if($order->status == 4)
                                        <a href="#" style="color:red;">For Store Pick up</a>
                                    @endif

                                    @if($order->status == 5)
                                        <a href="#" style="color:red;">To Receive</a>
                                    @endif

                                    @if($order->status == 6)
                                        <a href="#" style="color:red;">To Ship</a>
                                    @endif

                                    @if($order->status == 7)
                                        <a href="#" style="color:red;">Completed</a>
                                    @endif

                                </div>
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
                                @if($order->type == '1')
                                    <tr>
                                        <td>Shipping fee</td>
                                        <td>PHP {{ Helper::numberFormat($order->shipping_price) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>Total</td>
                                    <td>PHP {{ Helper::numberFormat(Helper::sumOfOrder($order->order_no) + $order->shipping_price) }}</td>
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

            <div class="products-header">
                <h1 class="stylish-heading">Logs</h1>
            </div>

            <div class="order-container">


                <div class="order-products">

                    <table class="table" style="width:100%">

                        <thead>
                            <tr>
                                <td>Action</td>
                                <td>Date</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($logs as $key => $value)
                                <tr>
                                    <td>{{ $value['action'] }}</td>
                                    <td>{{ $value['date_performed'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                </div>
                
            </div>

            <div class="spacer"></div>

            @if($order->status == 0 || $order->status == 2)

            <div class="cart-buttons">
                    <a href="{{ route('orders.change.status',['id' => str_replace("#","w",$order->order_no), 'action' => '1']) }}" class="button">Cancel Order</a>
            </div>

            @endif
        </div>
    </div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
