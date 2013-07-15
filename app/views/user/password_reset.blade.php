@extends('layouts.master')
@section('content')

{{ Form::open(array('action' => 'UsersController@postPasswordReset', 'method' => 'POST', 'class' => 'form-horizontal')) }}
<input type="hidden" name="token" value="{{ Input::get('token') }}">
<input type="text" name="email">
<input type="password" name="password">
<input type="password" name="password_confirmation">
<button type="submit" class="btn">Reset Password</button>

@stop