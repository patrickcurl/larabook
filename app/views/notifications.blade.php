<div style="padding-top:10px;">
@if (count($errors->all()) > 0)

<div class="alert alert-error alert-block">
	<a class="close" data-dismiss="alert">x</a>

  @if (Request::path() == "login" || Request::path() == "users/login")
    <h4>Login Error:</h4>
    Please see errors below, and try again.
	@elseif (Request::path()=="users/register")
    <h4>Registration Error:</h4>
    Please fix the errors below, and try again.
  @elseif (Request::path()=="lookup")
    <h4>Wrong ISBN</h4> Please try again.
  @else
    <h4>Error:</h4>
    Please check the form below for errors

  @endif
</div>
@endif

@if ($message = Session::get('success'))
<div data-alert class="alert alert-success">
<a class="close" data-dismiss="alert">x</a>
  {{{ $message }}}

</div>
@endif

@if ($message = Session::get('error'))
<div data-alert class="alert alert-error">
<a class="close" data-dismiss="alert">x</a>
  {{{ $message }}}

</div>
@endif

@if ($message = Session::get('warning'))
<div data-alert class="alert alert-block">
<a class="close" data-dismiss="alert">x</a>
  {{{ $message }}}

</div>
@endif

@if ($message = Session::get('info'))
<div data-alert class="alert alert-info">
<a class="close" data-dismiss="alert">x</a>
  {{{ $message }}}

</div>
@endif

@if ($message = Session::get('message'))
  <div data-alert class="alert alert-info">
  <a class="close" data-dismiss="alert">x</a>
    {{ $message }}

  </div>
@endif
</div>

