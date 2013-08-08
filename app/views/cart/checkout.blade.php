@extends('layouts.master')
@section('content')
	<h3>Checkout</h3>
	<br />
	<?
	Welcome : {{ $currentUser->first_name }}
	<div class="row-fluid">
		<div class="span8">
			<table class="table">
				<thead>
					<th>Item</th>
					<th>Price</th>
					<th>Qty</th>
					<th>Total</th>
				</thead>
				<tbody>
					@foreach($cart as $item)
					<tr>
						<td>
						<div class="row-fluid">

						<div class="span3"><img src="{{ $item->options->image_url }}" width="175" /></div>
            <div class="span9">
              <strong>{{ $item->options->Title }}</strong><br />
              Author: {{ $item->options->Author }}<br />
              Publisher: {{ $item->options->Publisher }}<br />
              Edition: {{ $item->options->Edition }}<br />
              ISBN10: {{ $item->options->ISBN10 }}<br />
              ISBN13: {{ $item->options->ISBN13 }}</div></div>
            </td>
            <td>${{ $item->price }}</td>
            <td>{{ $item->qty }}</td>
            <td>${{ number_format($item->subtotal,2) }}</td>

					</tr>
					@endforeach
					<tr><td colspan="4"><div style="text-align:right;">
						<a href="{{ URL::to('cart') }}"><button type="button" name="edit_cart" class="btn btn-success">View Cart</button></a>
						<a href="{{ URL::to('users/edit') }}"><button type="button" name="edit_profile" class="btn btn-success">Edit Profile</button></a>
						<a href="{{ URL::to('cart/checkout-complete') }}"><button type="button" name="checkout_complete" class="btn btn-success">Complete Checkout</button></a>

					</div></td></tr>
				</tbody>
			</table>
		</div>
		<div class="span4">
			<table class="table table-striped">
				<thead>
					<tr><th colspan="2">Customer Profile</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>Name</td>
						<td>{{ $currentUser->first_name }} {{ $currentUser->last_name }}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>{{ $currentUser->email }}</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>{{ $currentUser->phone }}</td>
					</tr>
					<tr>
						<td>Address</td>
						<td>{{ $currentUser->address }}</td>
					</tr>
					<tr>
						<td>City</td>
						<td>{{ $currentUser->city }}</td>
					</tr>
					<tr>
						<td>State</td>
						<td>{{ $currentUser->state }}</td>
					</tr>
					<tr>
						<td>Zip</td>
						<td>{{ $currentUser->zip }}</td>
					</tr>
					<tr>
						<td>Payment Method</td>
						<td>{{ $currentUser->payment_method }}</td>
					</tr>
					<tr>
						<td>Paypal Email</td>
						<td>{{ $currentUser->paypal_email }}</td>
					</tr>
				</tbody>

			 </table>

		</div>

	</div>


@stop