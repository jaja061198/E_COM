@php
    use App\Helper\Helper;
    use App\Http\Controllers\OrdersController;
@endphp

@extends('layout')

@section('title', 'My Profile')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

    @component('components.breadcrumbs')
        <a href="/">Home</a>
        <i class="fa fa-chevron-right breadcrumb-separator"></i>
        <span>My Profile</span>
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

            <ul>
              <li class="active"><a href="{{ route('users.edit') }}">My Profile</a></li>
              <li><a href="{{ route('users.shipping.edit') }}">Shipping Information</a></li>
              <li><a href="{{ route('orders.index') }}">Pending Orders</a> <font style="color: red;">({{ OrdersController::countOrders(0) }})</font></li>
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
                <h1 class="stylish-heading">My Profile</h1>
            </div>

            <div>
                <form action="{{ route('users.update') }}" method="POST">
                    {{-- @method('patch') --}}
                    {{ csrf_field() }}
                    <div class="form-control">
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Name" required>
                        <input type="hidden" name="get_id" value="{{ $user->id }}">
                    </div>
                    <div class="form-control">
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                        <input type="hidden" name="get_email" value="{{ $user->email }}">
                    </div>
                    <div class="form-control">
                        <input id="password" type="password" name="password" placeholder="Password">
                        <div>Leave password blank to keep current password</div>
                    </div>
                    <div class="form-control">
                        <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password">
                    </div>

                    <div>
                        <button type="submit" class="my-profile-button">Update Profile</button>
                    </div>

                </form>
            </div>

            <div class="spacer"></div>
        </div>
    </div>

<script>
    function hello()
    {
        var old_value = document.getElementById('phone').value;

        var Regex = /^[0-9]+$/;

        if(document.getElementById('phone').value.length < 11)
        {
            alert('Invalid Length');

            document.getElementById('phone').value = "";

            return false;

        }

        // if(Regex.test(old_value))
        // {
        //     alert('Invalid Characters');

        //     document.getElementById('phone').value = "";

        //     return false;
        // }

        var prefix = "+(639) ";

        var first_five = document.getElementById('phone').value.substr(2,5);

        var last_four = document.getElementById('phone').value.substr(7);

        var complete = prefix + first_five + " " + last_four;
        // alert(complete);

        if( complete.length > 17)
        {
            alert(complete.length);

            document.getElementById('phone').value = "";

            return false;
        }
        else
        {
        document.getElementById('phone').value = prefix + first_five + " " + last_four;
        }
    }
</script>
@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
