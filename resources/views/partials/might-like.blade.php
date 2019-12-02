@php
    use App\Helper\Helper;
@endphp
<div class="might-like-section">
    <div class="container">
        <h2>You might also like...</h2>
        <div class="might-like-grid">
            @foreach ($mightAlsoLike as $product)
                <a href="{{ route('shop.show', $product->ITEM_CODE) }}" class="might-like-product">
                    <img src="http://localhost:8000/{{ $product['IMAGE'] }}" alt="product">
                    <div class="might-like-product-name">{{ $product->ITEM_DESC }}</div>
                    <div class="might-like-product-price">PHP {{ Helper::numberFormat($product['STANDARD_PRICE']) }}</div>
                </a>
            @endforeach

        </div>
    </div>
</div>
