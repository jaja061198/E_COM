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
        <span>Terms And Conditions</span>
    @endcomponent

    <div class="container">
       

       <div class="products-section container">
        <div class="sidebar">
            <ul>
                <li class="active"><a href="{{ route('about.us') }}">Terms</a></li>
            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">Terms And Conditions</h1>
            </div>

            {{-- <div class="products text-center"> --}}
                <div>
                    {!! $items['description'] !!}
                </div>
            {{-- </div> end products --}}

            <div class="spacer"></div>
            {{-- {{ $products->appends(request()->input())->links() }} --}}
        </div>
    </div>

    </div>


    <div class="spacer" style="margin-bottom: 50%;"></div>

@endsection

@section('extra-js')
    <!-- Include AlgoliaSearch JS Client and autocomplete.js library -->
    <script src="https://cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js"></script>
    <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
    <script src="{{ asset('js/algolia.js') }}"></script>
@endsection
