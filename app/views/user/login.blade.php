@extends('layouts.master')
@section('content')
	<div class="row-fluid">

		<div class="span6">
			<h2>Register</h2>
			<br />
			{{ Form::open(array('action' => 'UsersController@postRegister', 'method' => 'POST', 'class' => 'form-horizontal')) }}

				<div class="control-group <?php if($errors->has('first_name')){echo "error";} ?>">
			   	<label class="control-label" for="first_name">First Name</label>
			   	<div class="controls">
			     	{{ Form::text('first_name', Input::get('first_name'), array('id' => 'first_name', 'placeholder' => 'First Name')) }}
			   		@foreach($errors->get('first_name') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('last_name')){echo "error";} ?>">
			   	<label class="control-label" for="last_name">Last Name</label>
			   	<div class="controls">

			     	{{ Form::text('last_name', Input::get('last_name'), array('id' => 'last_name', 'placeholder' => 'Last Name')) }}
			     	@foreach($errors->get('last_name') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('email')){echo "error";} ?>" >
			   	<label class="control-label" for="email">Email</label>
			   	<div class="controls">
		     		{{ Form::email('email', Input::get('email'), array('id' => 'email', 'placeholder' => 'E-mail Address')) }}
			     		@foreach($errors->get('email') as $message)
			     		<p class="text-error">{{$message}}</p>
			     		@endforeach




			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('password')){echo "error";} ?>">
			   	<label class="control-label" for="password">Password</label>
			   	<div class="controls">
			     	{{ Form::password('password', Input::get('password'), array('id' => 'password', 'placeholder' => 'Password'))}}
			     	@foreach($errors->get('password') as $message)
			     		<p class="text-error">{{$message}}</p>
			     		@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('password_confirmation')){echo "error";} ?>">
			   	<label class="control-label" for="password_confirmation">Confirm Password</label>
			   	<div class="controls">

 						{{ Form::password('password_confirmation', Input::get('password_confirmation'), array('id' => 'password_confirmation', 'placeholder' => 'Password Confirmation'))}}
			     	@foreach($errors->get('password_confirmation') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>


			  <div class="control-group <?php if($errors->has('phone')){echo "error";} ?>">
			   	<label class="control-label" for="phone">Phone</label>
			   	<div class="controls">
			     	{{ Form::text('phone', Input::get('phone'), array('id' => 'phone', 'placeholder' => 'Phone Number(10 Digits)')) }}
			     	@foreach($errors->get('phone') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('address')){echo "error";} ?>">
			   	<label class="control-label" for="address">Address</label>
			   	<div class="controls">
			     	{{ Form::text('address', Input::get('address'), array('id' => 'address', 'placeholder' => 'Mailing Address')) }}
			     	@foreach($errors->get('address') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('city')){echo "error";} ?>">
			   	<label class="control-label" for="city">City</label>
			   	<div class="controls">
			 	  	{{ Form::text('city', Input::get('city'), array('id' => 'city', 'placeholder' => 'City')) }}
			     	@foreach($errors->get('city') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('state')){echo "error";} ?>">
			   	<label class="control-label" for="state">State</label>
			   	<div class="controls">
			   	{{ Form::select('state', $state_list, Input::get('state')) }}

			     	@foreach($errors->get('state') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('zip')){echo "error";} ?>">
			   	<label class="control-label" for="zip">Zip Code</label>
			   	<div class="controls">
			     	{{ Form::text('zip', Input::get('zip'), array('placeholder' => 'Zip Code')) }}
			     	@foreach($errors->get('zip') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>
			  <div class="control-group <?php if($errors->has('payment_method')){echo "error";} ?>">
			  	<label class="control-label" for="payment_method">Payment Method</label>
			  	<div class="controls">
			   		<label class="radio inline">
			   			<input type="radio" id="payment_method" name="payment_method" value="Check" <?php if(Input::old('payment_method')=='Check'){echo "checked=\"checked\"";} ?> />Check
						</label>

						<label class="radio inline">
			   			<input type="radio" id="payment_method" name="payment_method" value="Paypal" <?php if(Input::old('payment_method')=='Paypal'){echo "checked=\"checked\"";} ?> />Paypal

						</label>
					</div>
			  </div>
			  <div class="control-group">
			   	<label class="control-label" for="paypal_email">Paypal Email Address</label>
			   	<div class="controls">
			     	<input type="text" id="paypal_email" name="paypal_email" placeholder="Paypal Email Address">
			   	</div>

			  </div>
			  <div class="control-group">
			   	<div class="controls">
			  <button type="submit" class="btn">Register</button>
			</div></div>
			{{ Form::close() }}
		</div>

		<div class="span4">
			<h2 style="text-align:center">Login</h2>
			<br />
			{{ Form::open(array('action' => 'UsersController@postLogin', 'method' => 'POST', 'class' => 'form-horizontal')) }}

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

			@if (Session::has('error'))
    {{ trans(Session::get('reason')) }}
@elseif (Session::has('success'))
    An e-mail with the password reset has been sent.
@endif
			<h2 style="text-align:right">Password Reset</h2>
				{{ Form::open(array('action' => 'UsersController@postPasswordReset', 'method' => 'POST', 'class' => 'form-horizontal')) }}
				<div class="control-group">
					<label class="control-label" for="email">Email</label>
					<div class="controls">
						<input type="text" name="email"><br /><br />
						<button type="submit" class="btn">Reset Password</button>
					</div>
				</div>

		</div>

	</div>


@stop