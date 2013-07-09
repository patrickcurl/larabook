<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users', function($t){
			$t->increments('id');
			$t->string('first_name', 50);
			$t->string('last_name', 50);
			$t->string('email', 255)->unique();
			$t->string('password', 255);
			$t->string('phone', 20);
			$t->string('address', 80);
			$t->string('city', 60);
			$t->string('state', 5);
			$t->string('zip', 10);
			$t->string('payment_method', 20);
			$t->string('paypal_email', 255)->nullable();
			$t->timestamps();
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
	}

}