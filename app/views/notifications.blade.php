@if (count($errors->all()) > 0)
<div class="alert alert-error alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4>Error</h4>
	Please check the form bellow for errors
</div>
@endif

@if ($message = Session::get('success'))
<div data-alert class="alert-box">
  {{{ $message }}}
  <a href="#" class="close">&times;</a>
</div>
@endif

@if ($message = Session::get('error'))
<div data-alert class="alert-box alert">
  {{{ $message }}}
  <a href="#" class="close">&times;</a>
</div>
@endif

@if ($message = Session::get('warning'))
<div data-alert class="alert-box .alert">
  {{{ $message }}}
  <a href="#" class="close">&times;</a>
</div>
@endif

@if ($message = Session::get('info'))
<div data-alert class="alert-box">
  {{{ $message }}}
  <a href="#" class="close">&times;</a>
</div>
@endif