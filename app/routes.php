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




//-- Books Contoller Methods -- //
Route::get('login', 'UsersController@getLogin');
// Route::post('lookup', 'BooksController@postLookup');
Route::post('books/isbn', 'BookController@getIsbn');
Route::controller('books', 'BookController');
Route::controller('users', 'UsersController');
Route::controller('cart', 'CartController');
Route::controller('orders', 'OrdersController');
Route::controller('admin', 'AdminController');


//Route::get('book/{slug?}', 'BooksController@getBook');
Route::get('/', function(){
  return View::make('home');
});
Route::get('test', function(){
  return View::make('test');
});