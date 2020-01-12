@php
    use App\Helper\Helper;
    use App\Http\Controllers\OrdersController;
@endphp
@extends('layout')

@section('title', 'My Orders')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">


<style>
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 100px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
      background-color: #fefefe;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    /* The Close Button */
    .close {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
</style>
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
              <li ><a href="{{ route('orders.index') }}">Pending Orders</a> <font style="color: red;">({{ OrdersController::countOrders(0) }})</font></li>
              <li class="active"><a href="{{ route('payment.index') }}">For Payment </a> <font style="color: red;">({{ OrdersController::countOrders(2) }})</font></li>
              <li><a href="{{ route('orders.pickup') }}">For Store Pickup</a> <font style="color: red;">({{ OrdersController::countOrders(4) }})</font></li>
              <li><a href="{{ route('orders.shipping') }}">For Shipping</a> <font style="color: red;">({{ OrdersController::countOrders(6) }})</font></li>
              <li><a href="{{ route('orders.received') }}">To Receive</a> <font style="color: red;">({{ OrdersController::countOrders(5) }})</font></li>
              <li><a href="{{ route('orders.complete') }}">Completed</a> <font style="color: red;">({{ OrdersController::countOrders(7) }})</font></li>
              <li><a href="{{ route('orders.cancel') }}">Cancelled Order</a> <font style="color: red;">({{ OrdersController::countOrders(1) }})</font></li>
            </ul>
        </div> <!-- end sidebar -->
        <div class="my-profile">
            <div class="products-header">
                <h1 class="stylish-heading">My Cancelled Orders</h1>
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
                                <div>| <button type="button" class="btn btn-primary" id="myBtn" onclick="showModal(this)" data-id="{{ $order['order_no'] }}" @if($order['status'] == '3') disabled @endif>Upload payment info</button></div>
                                <div>| @if($order['status'] == '2')<b style="color:red;">WAITING FOR PAYMENT</b>@endif @if($order['status'] == '3')<b style="color:red;">FOR PAYMENT REVIEW</b>@endif</div>
                                {{-- <div><a href="#">Invoice</a></div> --}}
                            </div>
                        </div>
                    </div>
    
                </div> <!-- end order-container -->
                @endforeach
            </div>

            <div class="spacer"></div>
        </div>
    </div>

<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content" style="width: 30%;">
    <span class="close">&times;</span>
    <p>Please upload the scanned payment information for <font id="or"></font></p>

    <form action="{{ route('payment.post') }}" method="post" enctype="multipart/form-data">
         {{ csrf_field() }}
        <div>
            <input id="code" name="code" type="hidden" class="form-control">

            <input type="file" class="form-control" id="add_item_image" name="add_item_image" onchange="loadFile(event)" required accept="image/*">
        </div>

        <div>
            <label for="recipient-name" class="col-form-label"><i style="color:red;"></i> Image Preview:</label>  <small style="color:red;visibility: hidden;" id="user_msg"><i></i></small>
            <img id="output" name="add_item_img" src="#" alt="your image" style="height: 80px;width: 80px;background-color: grey;">
        </div>

        <div class="spacer"></div>

        <div>
            <button type="submit" class="auth-button">Upload Payment Info</button>
        </div>

    </form>

  </div>

</div>
@endsection

@section('extra-js')
`<script>

   var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function(){
      var output = document.getElementById('output');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  };;
// Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    // btn.onclick = function() {
    //   modal.style.display = "block";
    // }

    function showModal(values)
    {
        modal.style.display = "block";
        var refcode = values.getAttribute('data-id');
        document.getElementById('code').value = refcode;
         document.getElementById('or').innerHTML = refcode;
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      document.getElementById('output').setAttribute('src','#');
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        document.getElementById('output').setAttribute('src','#');
        modal.style.display = "none";
      }
    }
</script>
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
