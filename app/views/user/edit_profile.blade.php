@extends('layouts.master')
@section('content')
{{ var_dump($errors) }}
<div class="row-fluid">
	<div class="span5 offset2">
<h3>:: Edit Profile ::</h3>
{{ Form::open(array('action' => 'UsersController@postUpdateProfile', 'method' => 'POST')) }}
<input type="hidden" name="id" value="{{ Auth::user()->id }}" />
<table class="table table-striped">
	<tr>
		<td>First Name</td>
		<td><input type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}" /></td>
	</tr>
	<tr>
		<td>Last Name</td>
		<td><input type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}" /></td>
	</tr>
	<tr>

		<td>Email</td>
		<td><input type="text" name="email" id="email" value="{{Auth::user()->email}}" /></td>
	</tr>
	<tr>
		<td>Password</td>
		<td><input type="password" name="password" id="password" value="" /></td>
	</tr>
	<tr>
		<td>Confirm Password</td>
		<td><input type="password" name="password_confirmation" id="password_confirmation" value="" /></td>
	</tr>
	<tr>
		<td>Phone</td>
		<td><input type="text" name="phone" id="phone" value="{{Auth::user()->phone}}" /></td>
	</tr>
	<tr>
		<td>Address</td>
		<td><input type="text" name="address" id="address" value="{{Auth::user()->address}}" /></td>
	</tr>
	<tr>
		<td>City</td>
		<td><input type="text" name="city" id="city" value="{{Auth::user()->city}}" /></td>
	</tr>
	<tr>
		<td>State</td>
		<td>	<select name="state">
			     		@foreach ($state_list as $name => $abbr )
			     			@if (Auth::user()->state == $abbr)
			     				<option value="{{ $abbr }}" selected="selected">{{ $name }}</option>
			     			@else
			     				<option value="{{ $abbr }}">{{ $name }}</option>
			     			@endif
			     		@endforeach</td>
	</tr>
	<tr>
		<td>Zip</td>
		<td><input type="text" name="zip" id="zip" value="{{Auth::user()->zip}}" /></td>
	</tr>
	<tr>
		<td>Payment Method</td>
		<td><input type="text" name="payment_method" id="payment_method" value="{{Auth::user()->payment_method}}" /></td>
	</tr>
	<tr>
		<td>Paypal Email</td>
		<td><input type="text" name="paypal_email" id="paypal_email" value="{{Auth::user()->paypal_email}}" /></td>
	</tr>
	<tr>
		<td></td>
		<td><div class="offset3">{{ Form::submit('Update Profile', array('class' => 'btn btn-large')) }}</div></td>
	</tr>
</table>{{ Form::close() }}
</div></div>

@stop