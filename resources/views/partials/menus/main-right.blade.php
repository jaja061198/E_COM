@php
    use App\Helper\Helper;
@endphp
<ul>
    @guest
    <li><a href="{{ route('register') }}">Sign Up</a></li>
    <li><a href="{{ route('login') }}">Login</a></li>
    @else

    <li>
        <a href="{{ route('terms.index') }}">Terms And Conditions</a>
    </li>

    <li>
        <a href="{{ route('payment.guide.index') }}">Payment Guide</a>
    </li>

    <li>
        <a href="{{ route('users.edit') }}">My Account</a>
    </li>

     <li><a href="{{ route('cart.index') }}">Cart
    @if (Helper::getCartCount() > 0)
    <span class="cart-count"><span>{{ Helper::getCartCount() }}</span></span>
    @endif
    </a></li>
    {{-- @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->link() }}">
                {{ $menu_item->title }}
                @if ($menu_item->title === 'Cart')
                    @if (Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{ Cart::instance('default')->count() }}</span></span>
                    @endif
                @endif
            </a>
        </li>
    @endforeach --}}
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
   
</ul>
