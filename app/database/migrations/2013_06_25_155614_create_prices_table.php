<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prices', function(Blueprint $t)
		{
			$t->increments('id');
			$t->string('condition');
			$t->string('type'); //buying or selling
			$t->integer('book_id')->unsigned();
			$t->integer('merchant_id')->unsigned();
			$t->float('amount');
			$t->string('buy_url');
			$t->timestamps();
			$t->foreign('book_id')->references('id')->on('books');
			$t->foreign('merchant_id')->references('id')->on('merchants');
		});

	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prices');
	}

}
