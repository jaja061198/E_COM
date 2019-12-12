@php
	use App\Helper\Helper;
@endphp
<footer>
    <div class="footer-content container">
        <div class="made-with">Feel free to contact us at : {{ Helper::getFooterText()->contact }} <br>Email : {{ Helper::getFooterText()->email }}
			<ul>
        		<li><a href="{{ URL(htmlspecialchars(Helper::getFooterText()->facebook)) }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
				
				&nbsp;&nbsp;&nbsp;
        		<li><a href="{{ URL(htmlspecialchars(Helper::getFooterText()->twitter)) }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
				&nbsp;&nbsp;&nbsp;
        		<li><a href="{{ URL(htmlspecialchars(Helper::getFooterText()->instagram)) }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
				&nbsp;&nbsp;&nbsp;
        		{{-- <li><a href="{{ URL(htmlspecialchars(Helper::getFooterText()->email)) }}"><i class="fa fa-google"></i></a></li> --}}
			</ul>
        </div>
        
    </div> <!-- end footer-content -->
</footer>
