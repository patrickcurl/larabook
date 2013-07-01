<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
    <title>
    	@section('title')
    	Laravel 4 - Foundation App
    	@show
    </title>

    <link href="{{{ asset('css/normalize.css') }}}" rel="stylesheet">
    <link href="{{{ asset('css/foundation.css') }}}" rel="stylesheet">
    <link href="{{{ asset('css/responsive-tables.css') }}}" rel="stylesheet" media="screen" type="text/css">
    <script type="text/javascript" src="{{{ asset('responsive-tables.js') }}}"></script>
    <script src="{{{ asset('js/vendor/custom.modernizr.js') }}}"></script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>

	<div class=""><nav class="top-bar" >
		<ul class="title-area">
			<li class="name"><h1><a href="{{{ URL::to('') }}}">home</a></h1></li>
			<li class="toggle-topbar menu-icon">
				<a href="#">
					<span>menu</span>
				</a>
			</li>
		</ul>

		<section class="top-bar-section">
			<ul class="right">
				<!-- 
				@if (Auth::check())
				<li><a href="{{{ URL::to('account') }}}">Account</a></li>
				<li><a href="{{{ URL::to('account/logout') }}}">Logout</a></li>
				@else
				<li class="divider"></li>
				<li class="{{{ (Request::is('account/login') ? 'active' : '') }}}"><a href="{{{ URL::to('account/login') }}}">Login</a></li>
				<li class="divider"></li>
				<li class="{{{ (Request::is('account/register') ? 'active' : '') }}}"><a href="{{{ URL::to('account/register') }}}">Register</a></li>
				@endif
			-->
			</ul>
		</section>
	</nav>
</div>


	<div class="row" style="margin-top:50px;">
		<div class="large-12">
	    @include('notifications')

	    @yield('content')
		</div>
	</div>



<!-- Javascripts -->
<script src="{{{ asset('assets/js/vendor/zepto.js') }}}"></script>
<script src="{{{ asset('assets/js/vendor/jquery.js') }}}"></script>
<script src="{{{ asset('assets/js/foundation.min.js') }}}"></script>
<!--

<script src="js/foundation/foundation.js"></script>

<script src="js/foundation/foundation.dropdown.js"></script>

<script src="js/foundation/foundation.alerts.js"></script>

<script src="js/foundation/foundation.clearing.js"></script>

<script src="js/foundation/foundation.placeholder.js"></script>

<script src="js/foundation/foundation.forms.js"></script>

<script src="js/foundation/foundation.cookie.js"></script>

<script src="js/foundation/foundation.joyride.js"></script>

<script src="js/foundation/foundation.magellan.js"></script>

<script src="js/foundation/foundation.orbit.js"></script>

<script src="js/foundation/foundation.reveal.js"></script>

<script src="js/foundation/foundation.section.js"></script>

<script src="js/foundation/foundation.tooltips.js"></script>

<script src="js/foundation/foundation.topbar.js"></script>

-->

<script>
  $(document).foundation();
</script>
</body>
</html>