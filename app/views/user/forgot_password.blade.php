@extends('layouts.master')
@section('content')


	<div class="row-fluid">
		<h2 style="text-align:center">Forgot Your Password? No Worries!</h2>
		<div class="span4"><img src="{{{ asset('img/forgotpassword.jpg') }}}"></div>
		<div class="span5">

				{{ Form::open(array('action' => 'UsersController@postForgotPassword', 'method' => 'POST', 'class' => 'form-horizontal')) }}
				<div class="control-group">
					<h2 style="text-align:right">Reset Password</h2><br />
					<label class="control-label" for="email">Email</label>
					<div class="controls">
						<input type="text" name="email"><br /><br />
						<button type="submit" class="btn">Reset Password</button>
					</div>
				</div>
				{{ Form::close() }}
		</div>
	</div>
@stop