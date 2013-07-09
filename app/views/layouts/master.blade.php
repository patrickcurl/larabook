<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    	@section('title')
    	Top Book Prices :: Get the Best Price for TextBooks
    	@show
    </title>
     <link href="css/bootstrap.min.css" rel="stylesheet">

 <style type="text/css">
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
      /*  padding: 14px 24px; */
      }


      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<body>

	<!-- <div class=""><nav class="top-bar" >
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
				 
				@if (Auth::check())
				<li><a href="{{{ URL::to('account') }}}">Account</a></li>
				<li><a href="{{{ URL::to('account/logout') }}}">Logout</a></li>
				@else
				<li class="divider"></li>
				<li class="{{{ (Request::is('account/login') ? 'active' : '') }}}"><a href="{{{ URL::to('account/login') }}}">Login</a></li>
				<li class="divider"></li>
				<li class="{{{ (Request::is('account/register') ? 'active' : '') }}}"><a href="{{{ URL::to('account/register') }}}">Register</a></li>
				@endif
			
			</ul>
		</section>
	</nav>
</div>
-->

	<!-- <div class="row" style="margin-top:50px;">
		<div class="large-12">
			<img src="{{{ asset('img/topbookprices.png') }}}" />
	    
		</div>
	</div>
-->

  <div class="container">

      <div class="masthead">
        <img src="{{{ asset('img/topbookprices.png') }}}" />
        <div class="navbar">
          <div class="navbar-inner">
            <div class="container">
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
        </div><!-- /.navbar -->
      </div>
			@include('notifications')

	    @yield('content')
      <!-- Jumbotron -->
     

      <hr>

      <div class="footer">
        <p>&copy; TopBookPrices.com 2013</p>
      </div>

    </div>  <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/vendor/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
})

$('#myTab a[href="#buy"]').tab('show');

  </script>
  </body>
</html>