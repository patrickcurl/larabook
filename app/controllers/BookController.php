<?php

class BookController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function __construct(){
		$this->beforeFilter('csrf', array('on' => 'post'));
	}
	
	protected $layout = 'layouts.master';

	public function postLookup()
	{
    $book = Book::find_or_create(Input::get('isbn'));
		return View::make('lookup', array('book' => $book));
	}

	
}