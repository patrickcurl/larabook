<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('home', 'HomeController@showWelcome');
// Route::get('lookup', 'HomeController@showLookup');
Route::get('/', function(){

	return View::make('home');
});

// Route::post('lookup', function(){

// 	return View::make('lookup');
// });


//-- Books Contoller Methods -- //
Route::post('lookup', 'BooksController@postLookup');
Route::get('lookup', 'BooksController@getLookup');



//-- Cart Controller Methods --//
Route::get('cart', 'CartController@viewCart');
Route::post('addCartItem', 'CartController@addCartItem');
Route::get('removeCartItem', 'CartController@removeCartItem');
Route::post('update_cart', 'CartController@updateCart');
Route::get('empty_cart', 'CartController@emptyCart');
Route::get('checkout', 'CartController@checkout');
Route::get('checkout_complete', 'CartController@checkout_complete');



//Route::get('login', array('as' => 'login', function(){}))->before('guest');
//-- UsersController --//
/*Route::post('register', 'UsersController@postRegister');
Route::post('login', 'UsersController@postLogin');
Route::get('login', 'UsersController@getLogin');
Route::get('logout', 'UsersController@getLogout')->before('auth');
Route::get('profile', 'UsersController@getProfile');
Route::get('edit_profile', 'UsersController@getEditProfile');
Route::post('update_profile', 'UsersController@postUpdateProfile');
Route::post('forgot_password', 'UsersController@postForgotPassword');
Route::get('password_reset', 'UsersController@getPasswordReset');
Route::post('password_reset', 'UsersController@postPasswordReset');
Route::post('reset_password', 'UsersController@postResetPassword');
*/
Route::controller('users', 'UsersController');
Route::controller('orders', 'OrdersController');
Route::controller('books', 'BooksController');
/* Route::get('password_reset/{token}', function($token)
	{
		return View::make('user.password_reset')->with('token', $token);
	});
*/

//Route::get('forgot_password', 'UsersController@getForgotPassword');
//	public function getPasswordReset(){
//		return Redirect::to('login')->with('message', 'Reset Password Email Sent, check e-mail.');
//	}
//Route::post('change_pass', 'UsersController@postChangePass');

//-- OrdersController --//
//Route::get('view_orders', 'OrdersController@view_orders');
//Route::get('print_label', 'OrdersController@print_label');
Route::get('login', 'UsersController@getLogin');
Route::get('test', function(){
	return View::make('test');
});

//-- Admin Controller --//
//Route::get('admin', 'AdminController@getDashboard');

Route::controller('admin', 'AdminController');