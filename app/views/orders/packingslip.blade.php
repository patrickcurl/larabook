@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Home
@stop
@section('body')
  onload="window.print();"
@stop
@section('logo')
  class="hide"
  @stop
{{-- Content --}}
@section('content')



  @if (Sentry::check())
<?php

$currentUser = Sentry::getUser();
?>

<div class="row-fluid">
<h1>Packing Slip</h1>
<table>
  <tr>
    <td style="padding-right:20px;"><strong>Ship To:</strong></td>
    <td style="width: 400px">
                <br />RecycleABook.com
                <br />Attn: Chris Harbaugh
                <br />561 Congress Park Dr
                <br />Dayton, OH 45459</td>
                </td>
    <td style="padding-right:20px;"><strong>Ship From:</strong></td>
    <td>
               <br /> {{ $currentUser->first_name }} {{ $currentUser->last_name }}
                <br />{{ $currentUser->address }}
                <br />{{ $currentUser->city }}, {{ $currentUser->state }} {{ $currentUser->zip }}</td>

</tr></table>


<table class="table">
                  <tr>
                    <td>Title</td>
                    <td>ISBN</td>
                    <td>Author</td>
                    <td>QTY</td>
                    <td>Price</td>
                  </tr>
                @foreach ($items as $item)

                  <tr>
                    <td>{{ $item->title}}</td>
                    <td>{{$item->isbn13}}</td>
                    <td>{{ $item->author}}</td>
                    <td>{{ $item->qty}}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                  </tr>
                @endforeach
              </table>

</div>
<div class="well offset8 span2"><strong>Total: </strong>${{ number_format($orderTotal ,2)}}</div>

@endif
@stop
