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
<!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        xfbml            : true,
        version          : 'v5.0'
      });
    };

    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your customer chat code -->
  <div class="fb-customerchat"
    attribution=setup_tool
    page_id="101529601389962"
theme_color="#fa3c4c">
  </div>