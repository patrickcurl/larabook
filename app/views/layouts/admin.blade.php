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
     <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">


    <link href="{{ URL::asset('css/bootstrap-responsive.css') }}" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Syncopate' rel='stylesheet' type='text/css'>
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
    <!-- Fav and touch icons -->
    <?php /*
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png"> */ ?>
      <style type="text/css">
      body {
        padding-top: 40px;
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
        margin: 10px 0;
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
      .navbar-custom1 {
        padding: 0;
      }
      .navbar-custom2 {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav_custom3 li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav_custom3 li a {
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav_custom3 li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav_custom3 li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
      .dropdown-menu li a{
        color: #0081c2;
        font-weight:bold;
      }
      .dropdown-menu li a:hover{
        color: white;
      }

      .home-blocks{ margin-top:40px; }
      .home-blocks .home-block-1 .block-content, .home-blocks .home-block-2 .block-content{
        border-left: 1px solid #d9e5e9;
        padding: 20px 0px 20px 20px;

      }
      .home-blocks .home-block-3 .block-content{
        border-left: 1px solid #d9e5e9;
        padding: 20px;
        border-right: 1px solid #d9e5e9;
      }
      .home-blocks h3{
        font-size: 30px;
        color: #1b4c5d;
        font-weight: normal;
      }

      .home-blocks p{
        color: #4dafd3;
        font-size: 20px;
        line-height: 20px;

      }

    </style>
    @section('head')
    @show
</head>

<body @section('body')
      @show >


<div class="navbar navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="{{ URL::to('/') }}">TopBookPrices.com</a>
                  <div class="nav-collapse collapse navbar-responsive-collapse">
                    <ul class="nav ">
                      <li class="active"><a href="{{ URL::to('/') }}">Home</a></li>



                    </ul>

                    <ul class="nav ">

                      <li class="divider-vertical"></li>

                     <?php /* <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
                        <ul class="dropdown-menu" style="padding-left:20px; padding-right:20px; padding: 5px 20px 20px 20px">
                        	@if (Sentry::check())
                          <?php $currentUser = Sentry::getUser(); ?>

                          <li><a href="{{ URL::to('/users/edit/' . $currentUser->id) }}">Edit Profile</a></li>
                          <!-- <li><a href="<?php //echo URL::to('/users/orders/' . $currentUser->id); ?>">View Orders</a></li> -->
                          <li class="divider"></li>
                          <li><a href="{{ URL::to('/users/logout') }}">Logout</a></li>
                          @else
                          <li class="nav-header">Login</li>
                          <li class="divider"></li>
                         {{ Form::open(array('action' => 'UsersController@getLogin', 'method' => 'POST')) }}
                          	<input type="text" name="email" placeholder="email" class="span2" style="padding-left:20px;" />
                          	<input type="password" name="password" placeholder="password" class="span2" style="padding-left:20px;" />
                            <button type="submit" class="btn btn-success">Sign in</button>
                          {{ Form::close() }}
                            <li class="divider"></li>
                            <li><a href="{{ URL::to('users/register') }}" >Register</a></li>
                          @endif

                        </ul>
                      </li> */ ?><!--
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Book Bag({{Cart::count() }})<b class="caret"></b></a>
                        <ul class="dropdown-menu">

                          <li><a href="{{ URL::to('/cart/view') }}">View Cart</a></li>
                          <li><a href="{{ URL::to('/cart/empty-cart') }}">Empty Cart</a></li>
                          <li><a href="{{ URL::to('/cart/checkout') }}">Checkout</a></li>
                          <li class="divider"></li>
                           <li><p class="navbar-text" style="padding-left:20px;">Cart Total: ${{Cart::total()}}</p></li>
                        </ul>
                      </li>
                      -->
                      {{ Form::open(array('action'=> 'BookController@getIsbn', 'method' => 'post', 'class' =>'navbar-search input-append pull-right')) }}

                        <input class="span2" name="isbn" placeholder="Enter ISBN #" id="appendedInputButton" type="text">
                        <button class="btn" type="submit">Get Prices</button>
                    {{ Form::close() }}
                    <li class="divider"></li>

                    </ul>
                    @if (Sentry::check())
                      <?php $currentUser = Sentry::getUser(); ?>
                    @if ($currentUser->hasAccess('admin'))
                    <ul class="nav"><li><a href="{{ URL::to('admin') }}"><strong>Admin</strong></a></li></ul>
                    @endif
                    @endif
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
  <div class="container">

      <div class="masthead">

        <img src="{{{ asset('img/topbookprices.png') }}}"
                    @section('logo')
                    @show
                    />

      </div>
			@include('notifications')
      @if (Session::has('error'))
    {{ trans(Session::get('reason')) }}
@endif
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="{{URL::to('admin')}}">Dashboard</a>
    <ul class="nav">
      <li><a href="{{URL::to('admin/merchants-features')}}">Merchants & Features</a></li>
      <li><a href="#">Users</a></li>
      <li><a href="#">Stats</a></li>

    </ul>
    <ul class="nav pull-right">
      <li><p class="navbar-text pull-right">Total Users: {{{ $data['totalUsers'] }}} | Online:  {{{ $data['onlineUsers'] }}} | Guests:  {{{ $data['onlineGuests'] }}}</p></li>
    </ul>
  </div>
</div>
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
    <script src="{{ URL::asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.js') }}"></script>

  @section('footer')
  @show
  </body>
</html>