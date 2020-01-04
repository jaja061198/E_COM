<div class="breadcrumbs">
    <div class="breadcrumbs-container container">
        <div>
            {{ $slot }}
        </div>
        @if(Request::route()->getName() == 'shop.index')
	        <div>
	            @include('partials.search')
	        </div>
        @endif
    </div>
</div> <!-- end breadcrumbs -->
