@extends('layouts.master')
@section('content')
	<h3>Checkout</h3>
	<br />
	@if(Auth::check())
	Welcome : {{ Auth::user()->first_name }}
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
						<a href="{{ URL::to('cart') }}"><button type="button" name="edit_cart" class="btn btn-success">Edit Cart</button></a>
						<a href="{{ URL::to('edit_profile') }}"><button type="button" name="edit_profile" class="btn btn-success">Edit Profile</button></a>
						<a href="{{ URL::to('checkout_complete') }}"><button type="button" name="checkout_complete" class="btn btn-success">Complete Checkout</button></a>

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
						<td>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>{{ Auth::user()->email }}</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>{{ Auth::user()->phone }}</td>
					</tr>
					<tr>
						<td>Address</td>
						<td>{{ Auth::user()->address }}</td>
					</tr>
					<tr>
						<td>City</td>
						<td>{{ Auth::user()->city }}</td>
					</tr>
					<tr>
						<td>State</td>
						<td>{{ Auth::user()->state }}</td>
					</tr>
					<tr>
						<td>Zip</td>
						<td>{{ Auth::user()->zip }}</td>
					</tr>
					<tr>
						<td>Payment Method</td>
						<td>{{ Auth::user()->payment_method }}</td>
					</tr>
					<tr>
						<td>Paypal Email</td>
						<td>{{ Auth::user()->paypal_email }}</td>
					</tr>
				</tbody>
	
			 </table>

		</div>

	</div>

	@else
	<div class="row-fluid">

		<div class="span5">
			<h2>Register</h2>
			<br />
			<form class="form-horizontal">
				
				<div class="control-group">
			   	<label class="control-label" for="inputFirstName">First Name</label>
			   	<div class="controls">
			     	<input type="text" id="inputFirstName" name="inputFirstName" placeholder="First Name">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputLastName">Last Name</label>
			   	<div class="controls">
			     	<input type="text" id="inputLastName" name="inputFirstName" placeholder="Last Name">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputEmail">Email</label>
			   	<div class="controls">
			     	<input type="text" id="inputEmail" placeholder="Email">
			   	</div>
			  </div>
			  
			  <div class="control-group">
			   	<label class="control-label" for="inputPassword">Password</label>
			   	<div class="controls">
			     	<input type="password" id="inputPassword" placeholder="Password">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputPhone">Phone</label>
			   	<div class="controls">
			     	<input type="text" id="inputPhone" name="inputPhone" placeholder="Phone">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputAddress">Address</label>
			   	<div class="controls">
			     	<input type="text" id="inputAddress" name="inputAddress" placeholder="Address">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputCity">City</label>
			   	<div class="controls">
			     	<input type="text" id="inputCity" name="inputCity" placeholder="City">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputState">State</label>
			   	<div class="controls">
			     	<select name="inputState">
			     		@foreach ($states as $name => $abbr )
			     		<option value="{{ $abbr }}">{{ $name }}</option>
			     		@endforeach
			     	</select>
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="inputZip">Zip Code</label>
			   	<div class="controls">
			     	<input type="text" id="inputZip" name="inputZip" placeholder="Zip Code">
			   	</div>
			  </div>

			  <div class="control-group">
			  	<label class="control-label" for="inputPaymentMethod">Payment Method</label>
			  	<div class="controls">
			   		<label class="radio inline">
			   			<input type="radio" name="inputPaymentMethod" name="inputPaymentMethod" value="Check" />Check
						</label>
						<label class="radio inline">
			   			<input type="radio" name="inputPaymentMethod" name="inputPaymentMethod" value="Paypal" />Paypal	
						</label>
					</div>
			  </div>
			  <div class="control-group">
			   	<label class="control-label" for="inputPaypalEmail">Paypal Email Address</label>
			   	<div class="controls">
			     	<input type="text" id="inputPaypalEmail" placeholder="Paypal Email Address">
			   	</div>
			  </div>
			</form>
		</div>

		<div class="span4">
			<h2 style="text-align:center">Login</h2>
			<br />
			{{ Form::open(array('action' => 'UsersController@postLogin', 'method' => 'POST', 'class' => 'form-horizontal')) }}
			<form class="form-horizontal">
			  <div class="control-group">
			   	<label class="control-label" for="email">Email</label>
			   	<div class="controls">
			     	<input type="text" id="email" name="email" placeholder="Email">
			   	</div>
			  </div>
			  <div class="control-group">
			   	<label class="control-label" for="password">Password</label>
			   	<div class="controls">
			     	<input type="password" id="password" name="password" placeholder="Password">
			   	</div>
			  </div>
			  <div class="control-group">
			   	<div class="controls">
			     	<label class="checkbox">
			       	<input type="checkbox"> Remember me
			     	</label>
			     	<button type="submit" class="btn">Sign in</button>
			   	</div>
			  </div>
			{{ Form::close() }}
		</div>

	</div>
	@endif
@stop