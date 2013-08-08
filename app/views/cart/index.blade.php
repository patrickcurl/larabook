@extends('layouts.master')
@section('content')
  <div class="row-fluid">
    <h2>Your Cart</h2>
    {{ Form::open(array('url' => 'cart/update', 'method' => 'post')) }}

    <table class="table table-striped">
      <tr>
          <td>Book</td>
          <td>Price</td>
          <td>Quantity</td>
          <td>Total Price</td>
          <td></td>
        </tr>
        <?php $count = 0; ?>
    @foreach ($cart as $item)
    <tr><td>
            <div class="row-fluid">
            <div class="span3"><img src="{{ $item->options->image_url }}" width="175" /></div>
            <div class="span7">
              @if (strlen($item->options->Title) > 70)
              <strong>{{ substr($item->options->Title, 0, 70) }}...</strong>
              @else
              <strong>{{ $item->options->Title }}</strong>
              @endif
              <br />
              Author: {{ $item->options->Author }}<br />
              Publisher: {{ $item->options->Publisher }}<br />
              Edition: {{ $item->options->Edition }}<br />
              Weight: {{ number_format($item->options->Weight,2) }}<br />
              ISBN: {{ $item->options->ISBN10 }} / {{ $item->options->ISBN13 }}</div>
            </div>
            </td>
            <td>${{ $item->price }}</td>
            <input type="hidden" name="items[{{$count}}][id]" value="{{ $item->rowid }}">
            <td><input class="input-mini" type="text" name="items[{{$count}}][qty]" value="{{ $item->qty }}" /></td>
            <td>${{ number_format($item->subtotal, 2) }}</td>
            <td> <a href="{{ URL::to('cart/remove')}}?itemId={{$item->rowid}}"><img src="img/cross.png" /></a>

          </tr>
          <?php $count++; ?>
    @endforeach
    <tr>
      <td></td>
      <td></td>
      <td colspan="3">
        <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
        {{ form::close() }}
        <a href="{{ URL::to('cart/empty') }}"><button type="button" name="empty_cart" class="btn btn-danger">Empty Cart</button></a>
        <a href="{{ URL::to('cart/checkout') }}"><button type="button" name="check_out" class="btn btn-success">Check Out</button></a>
        Total Price : ${{ number_format(Cart::total(), 2) }}
      </td>
    </tr>
  </table>
  </div>
@stop