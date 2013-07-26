@extends('layouts.master')

{{-- Web site Title --}}
@section('title')
@parent
Edit Profile
@stop

{{-- Content --}}
@section('content')

<h4 class="offset1">Edit
@if ($user->email == Sentry::getUser()->email)
	Your
@else
	{{ $user->email }}'s
@endif

Profile</h4>
<div class="well">
	<form class="form-horizontal" action="{{ URL::to('users/edit') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}
        <div class="row-fluid">

	        <div class="span5 control-group {{ ($errors->has('first_name')) ? 'error' : '' }}" for="first_name">
	        	<label class="control-label" for="first_ame">First Name:</label>
		    		<div class="controls">
							<input name="first_name" value="{{ (Request::old('first_name')) ? Request::old("first_name") : $user->first_name }}" type="text" class="input-xlarge" placeholder="First Name">
			    		{{ ($errors->has('first_name') ? $errors->first('first_name') : '') }}
	    			</div>
    			</div>

	        <div class="span4 control-group {{ $errors->has('last_name') ? 'error' : '' }}" for="last_name">
	        	<label class="control-label" for="last_name">Last Name:</label>
		    		<div class="controls">
						<input name="last_name" value="{{ (Request::old('last_name')) ? Request::old("last_name") : $user->last_name }}" type="text" class="input-xlarge" placeholder="Last Name">
		    			{{ ($errors->has('last_name') ?  $errors->first('last_name') : '') }}
		    		</div>
	    		</div>
    		</div>

        <div class="row-fluid">
	        <div class="span5 control-group {{ ($errors->has('email')) ? 'error' : '' }}" for="email">
	        	<label class="control-label" for="email">E-mail Address:</label>
		    		<div class="controls">
							<input name="email" value="{{ (Request::old('email')) ? Request::old("email") : $user->email }}" type="text" class="input-xlarge" placeholder="E-mail Address">
			    		{{ ($errors->has('email') ? $errors->first('email') : '') }}
	    			</div>
    			</div>

	        <div class="span4 control-group {{ $errors->has('phone') ? 'error' : '' }}" for="phone">
	        	<label class="control-label" for="phone">Phone:</label>
		    		<div class="controls">
						<input name="phone" value="{{ (Request::old('phone')) ? Request::old("phone") : $user->phone }}" type="text" class="input-xlarge" placeholder="Phone #">
		    			{{ ($errors->has('phone') ?  $errors->first('phone') : '') }}
		    		</div>
	    		</div>
    		</div>

    		<div class="row-fluid">
	        <div class="span5 control-group {{ ($errors->has('address')) ? 'error' : '' }}" for="address">
	        	<label class="control-label" for="address">Address:</label>
		    		<div class="controls">
							<input name="address" value="{{ (Request::old('address')) ? Request::old("address") : $user->address }}" type="text" class="input-xlarge" placeholder="Address">
			    		{{ ($errors->has('address') ? $errors->first('address') : '') }}
	    			</div>
    			</div>

	        <div class="span4 control-group {{ $errors->has('city') ? 'error' : '' }}" for="city">
	        	<label class="control-label" for="city">City:</label>
		    		<div class="controls">
						<input name="city" value="{{ (Request::old('city')) ? Request::old("city") : $user->city }}" type="text" class="input-xlarge" placeholder="City">
		    			{{ ($errors->has('city') ?  $errors->first('city') : '') }}
		    		</div>
	    		</div>
    		</div>
    		<div class="row-fluid">
	        <div class="span5 control-group {{ ($errors->has('state')) ? 'error' : '' }}" for="state">
	        	<label class="control-label" for="state">State:</label>
		    		<div class="controls">
							{{ Form::select('state', $state_list, $user->state) }}
			    		{{ ($errors->has('state') ? $errors->first('state') : '') }}
	    			</div>
    			</div>

	        <div class="span4 control-group {{ $errors->has('zip') ? 'error' : '' }}" for="zip">
	        	<label class="control-label" for="zip">Zip Code:</label>
		    		<div class="controls">
						<input name="zip" value="{{ (Request::old('zip')) ? Request::old("zip") : $user->zip }}" type="text" class="input-xlarge" placeholder="Zip Code">
		    			{{ ($errors->has('zip') ?  $errors->first('zip') : '') }}
		    		</div>
	    		</div>
    		</div>


    	<div class="form-actions offset1">
	    	<input class="btn-primary btn" type="submit" value="Update Profile">
	    	<input class="btn-inverse btn" type="reset" value="Reset">
	    </div>
    </form>
</div>
<h4 class="offset1">Payment Method</h4>
<div class="well">
		<form class="form-horizontal" action="{{ URL::to('users/changepassword') }}/{{ $user->id }}" method="post">

			<div class="control-group offset2">
					<label class="control-label" for="payment_method">Payment Method:</label>
					<div class="controls">
						<label class="radio inline">
								@if ($user->payment_method == "Check")
										<input type="radio" name="payment_method" name="payment_method" value="Check" checked="checked"/>Check
								@else
										<input type="radio" name="payment_method" name="payment_method" value="Check"/>Check
								@endif
						</label>
						<label class="radio inline">
								@if ($user->payment_method == "Paypal")
									<input type="radio" name="payment_method" name="payment_method" value="Paypal" checked="checked" />Paypal
								@else
									<input type="radio" name="payment_method" name="payment_method" value="Paypal" />Paypal
								@endif
						</label>
					</div>
				</div>

			<div class="control-group offset2" for="paypal_email">
				<label class="control-label" for="paypal_email">Paypal Email Address:</label>
				<div class="controls">
					<input type="text" id="paypal_email" name="paypal_email" placeholder="Paypal Email Address" value="{{ $user->paypal_email }}">
				</div>
			</div>


				<div class="control-group offset2" for="name_on_cheque"></div>
				<div class="control-group offset2" for="name_on_cheque">
					<label class="control-label" for="name_on_cheque">Make Check Payable to:</label>
					<div class="controls">
						<input type="text" id="name_on_cheque" name="name_on_cheque" placeholder="Check Payable to" value="{{ $user->name_on_cheque }}">
					</div>
				</div>

			<div class="form-actions offset1">
	    	<input class="btn-primary btn" type="submit" value="Update Payment Method">
	    	<input class="btn-inverse btn" type="reset" value="Reset">
	    </div>
		</form>
		</div>

<h4 class="offset1">Change Password</h4>
<div class="well">
	<form class="form-horizontal" action="{{ URL::to('users/changepassword') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}

        <div class="control-group offset1 {{ $errors->has('oldPassword') ? 'error' : '' }}" for="oldPassword">
        	<label class="control-label" for="oldPassword">Old Password</label>
    		<div class="controls">
				<input name="oldPassword" value="" type="password" class="input-xlarge" placeholder="Old Password">
    			{{ ($errors->has('oldPassword') ? $errors->first('oldPassword') : '') }}
    		</div>
    	</div>

        <div class="control-group offset1 {{ $errors->has('newPassword') ? 'error' : '' }}" for="newPassword">
        	<label class="control-label" for="newPassword">New Password</label>
    		<div class="controls">
				<input name="newPassword" value="" type="password" class="input-xlarge" placeholder="New Password">
    			{{ ($errors->has('newPassword') ?  $errors->first('newPassword') : '') }}
    		</div>
    	</div>

    	<div class="control-group  offset1 {{ $errors->has('newPassword_confirmation') ? 'error' : '' }}" for="newPassword_confirmation">
        	<label class="control-label" for="newPassword_confirmation">Confirm New Password</label>
    		<div class="controls">
				<input name="newPassword_confirmation" value="" type="password" class="input-xlarge" placeholder="New Password Again">
    			{{ ($errors->has('newPassword_confirmation') ? $errors->first('newPassword_confirmation') : '') }}
    		</div>
    	</div>

	    <div class="form-actions offset1">
	    	<input class="btn-primary btn" type="submit" value="Change Password">
	    	<input class="btn-inverse btn" type="reset" value="Reset">
	    </div>
      </form>
  </div>

@if (Sentry::check() && Sentry::getUser()->hasAccess('admin'))
<h4>User Group Memberships</h4>
<div class="well">
    <form class="form-horizontal" action="{{ URL::to('users/updatememberships') }}/{{ $user->id }}" method="post">
        {{ Form::token() }}

        <table class="table">
            <thead>
                <th>Group</th>
                <th>Membership Status</th>
            </thead>
            <tbody>
                @foreach ($allGroups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>
                            <div class="switch" data-on-label="In" data-on='info' data-off-label="Out">
                                <input name="permissions[{{ $group->id }}]" type="checkbox" {{ ( $user->inGroup($group)) ? 'checked' : '' }} >
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="form-actions">
            <input class="btn-primary btn" type="submit" value="Update Memberships">
        </div>
    </form>
</div>
@endif

@stop