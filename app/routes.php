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

	return View::make('hello');
});

// Route::post('lookup', function(){

// 	return View::make('lookup');
// });

Route::post('lookup', 'BookController@postLookup');
Route::get('lookup', 'BookController@getLookup');
Route::post('addCartItem', 'BookController@addCartItem');
Route::get('removeCartItem', 'BookController@removeCartItem');
Route::get('cart', 'BookController@viewCart');
Route::post('update_cart', 'BookController@updateCart');
Route::get('empty_cart', 'BookController@emptyCart');
Route::get('checkout', 'BookController@checkout');
//Route::get('login', array('as' => 'login', function(){}))->before('guest');
Route::post('login', 'BookController@login');
Route::get('logout', array('as' => 'logout', function(){}))->before('auth');
Route::get('profile', array('as' => 'profile', function(){}))->before('auth');
Route::get('edit_profile', 'BookController@editprofile');
Route::post('update_profile', 'BookController@updateprofile');
