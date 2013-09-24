@extends('layouts.admin')
@section('head')
@stop
@section('content')


<h3>Dashboard</h3>
  <div class="row-fluid">
   Total Users: {{{ $totalUsers }}} | Online:  {{{ $onlineUsers }}} | Guests:  {{{ $onlineGuests }}}

  </div>
  <div class="row">
    <div class="span3">
      <div class="container">
        <a href="{{URL::to('admin/merchants_and_features') }}">Merchants & Features</a>
      </div>
    </div>
    <div class="span3">
      <div class="container">
        <a href="{{URL::to('admin/merchants_and_features') }}">Merchants & Features</a>
      </div>
    </div>
    <div class="span3">
      <div class="container">
        <a href="{{URL::to('admin/merchants-features') }}">Merchants & Features</a>
      </div>
    </div>
  </div>
@stop
@section('footer')
<script>$('#navbar').affix()</script>
@stop