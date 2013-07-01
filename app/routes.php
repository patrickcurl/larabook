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

