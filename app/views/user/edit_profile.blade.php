@extends('layouts.master')
@section('content')



<h2>Edit Profile</h2>


<div class="row-fluid">
	{{ Form::open(array('action' => 'UsersController@postUpdateProfile', 'method' => 'POST', 'class' => 'form-horizontal')) }}
		<input type="hidden" name="id" value="{{ Auth::user()->id }}" />
		<div class="control-group span5">
			<label class="control-label" for="first_name">First Name</label>
			<div class="controls">
				<input type="text" id="first_name" name="first_name" placeholder="First Name" value="{{ Auth::user()->first_name }}">
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="last_name">Last Name</label>
			<div class="controls">
				<input type="text" id="last_name" name="last_name" placeholder="Last Name" value="{{ Auth::user()->last_name }}">
			</div>
		</div>

		<div class="control-group span5 <?php if($errors->has('email')){echo "error";} ?>" >
			<label class="control-label" for="email">Email</label>
			<div class="controls">
				<input type="text" id="email" name="email" placeholder="Email" value="{{ Auth::user()->email }}">
				@foreach($errors->get('email') as $message)
					<p class="text-error">{{$message}}</p>
				@endforeach
			</div>
		</div>
				<div class="control-group span5">
			<label class="control-label" for="phone">Phone</label>
			<div class="controls">
				<input type="text" id="phone" name="phone" placeholder="Phone" value="{{ Auth::user()->phone }}">
			</div>
		</div>
		<div class="control-group span5 <?php if($errors->has('password')){echo "error";} ?>">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
				<input type="password" name="password" id="password" placeholder="Password">
				@foreach($errors->get('password') as $message)
					<p class="text-error">{{$message}}</p>
				@endforeach
			</div>
		</div>
		<div class="control-group span5 <?php if($errors->has('password_confirmation')){echo "error";} ?>">
			<label class="control-label" for="password_confirmation">Confirm Password</label>
			<div class="controls">
				<input type="password" name ="password_confirmation" id="password_confirmation" placeholder="Password">
					@foreach($errors->get('password_confirmation') as $message)
						<p class="text-error">{{$message}}</p>
					@endforeach
			</div>
		</div>


		<div class="control-group span5">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
				<input type="text" id="address" name="address" placeholder="Address" value="{{ Auth::user()->address }}">
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="city">City</label>
			<div class="controls">
				<input type="text" id="city" name="city" placeholder="City" value="{{ Auth::user()->city }}">
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="state">State</label>
			<div class="controls">
				<select name="state">
					@foreach ($state_list as $name => $abbr )
						@if (Auth::user()->state == $abbr)
							<option value="{{ $abbr }}" selected="selected">{{ $name }}</option>
						@else
							<option value="{{ $abbr }}">{{ $name }}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="zip">Zip Code</label>
			<div class="controls">
				<input type="text" id="zip" name="zip" placeholder="Zip Code" value="{{ Auth::user()->zip }}">
			</div>
		</div>



		<div class="control-group span5">
			<label class="control-label" for="payment_method">Payment Method</label>
			<div class="controls">
				<label class="radio inline">
					@if (Auth::user()->payment_method == "Check")
						<input type="radio" name="payment_method" name="payment_method" value="Check" checked="checked"/>Check
					@else
						<input type="radio" name="payment_method" name="payment_method" value="Check"/>Check
					@endif
				</label>
				<label class="radio inline">
					@if (Auth::user()->payment_method == "Paypal")
						<input type="radio" name="payment_method" name="payment_method" value="Paypal" checked="checked" />Paypal
					@else
						<input type="radio" name="payment_method" name="payment_method" value="Paypal" />Paypal
					@endif
				</label>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="paypal_email">Paypal Email Address</label>
				<div class="controls">
					<input type="text" id="paypal_email" name="paypal_email" placeholder="Paypal Email Address" value="{{ Auth::user()->paypal_email }}">
				</div>
		</div>

	</div>
<div class="control-group span4 offset2">
			<div class="controls">
				{{ Form::submit('Update Profile', array('class' => 'btn btn-large')) }}
			</div>
		</div>
		{{ Form::close() }}



@stop