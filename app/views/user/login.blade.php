@extends('layouts.master')
@section('content')

	{{ var_dump($errors->has('email')) }}
	<div class="row-fluid">

		<div class="span6">
			<h2>Register</h2>
			<br />
			{{ Form::open(array('action' => 'UsersController@postRegister', 'method' => 'POST', 'class' => 'form-horizontal')) }}

				<div class="control-group">
			   	<label class="control-label" for="first_name">First Name</label>
			   	<div class="controls">
			     	<input type="text" id="first_name" name="first_name" placeholder="First Name">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="last_name">Last Name</label>
			   	<div class="controls">
			     	<input type="text" id="last_name" name="last_name" placeholder="Last Name">
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('email')){echo "error";} ?>" >
			   	<label class="control-label" for="email">Email</label>
			   	<div class="controls">
			   		
			   			
			     			<input type="text" id="email" name="email" placeholder="Email"> 
			     		@foreach($errors->get('email') as $message)
			     		<p class="text-error">{{$message}}</p>
			     		@endforeach
  					
  					
  						
						
			   	</div>
			  </div>
							  		  
			  <div class="control-group <?php if($errors->has('password')){echo "error";} ?>">
			   	<label class="control-label" for="password">Password</label>
			   	<div class="controls">

			     	<input type="password" name="password" id="password" placeholder="Password">
			     	@foreach($errors->get('password') as $message)
			     		<p class="text-error">{{$message}}</p>
			     		@endforeach
			   	</div>
			  </div>

			  <div class="control-group <?php if($errors->has('password_confirmation')){echo "error";} ?>">
			   	<label class="control-label" for="password_confirmation">Confirm Password</label>
			   	<div class="controls">

			     	<input type="password" name ="password_confirmation" id="password_confirmation" placeholder="Password">
			     	@foreach($errors->get('password_confirmation') as $message)
			     		<p class="text-error">{{$message}}</p>
			     	@endforeach
			   	</div>
			  </div>


			  <div class="control-group">
			   	<label class="control-label" for="phone">Phone</label>
			   	<div class="controls">
			     	<input type="text" id="phone" name="phone" placeholder="Phone">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="address">Address</label>
			   	<div class="controls">
			     	<input type="text" id="address" name="address" placeholder="Address">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="city">City</label>
			   	<div class="controls">
			     	<input type="text" id="city" name="city" placeholder="City">
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="state">State</label>
			   	<div class="controls">
			     	<select name="state">
			     		@foreach ($state_list as $name => $abbr )
			     		<option value="{{ $abbr }}">{{ $name }}</option>
			     		@endforeach
			     	</select>
			   	</div>
			  </div>

			  <div class="control-group">
			   	<label class="control-label" for="zip">Zip Code</label>
			   	<div class="controls">
			     	<input type="text" id="zip" name="zip" placeholder="Zip Code">
			   	</div>
			  </div>

			  <div class="control-group">
			  	<label class="control-label" for="payment_method">Payment Method</label>
			  	<div class="controls">
			   		<label class="radio inline">
			   			<input type="radio" name="payment_method" name="payment_method" value="Check" />Check
						</label>
						<label class="radio inline">
			   			<input type="radio" name="payment_method" name="payment_method" value="Paypal" />Paypal	
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

@stop