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
			$t->integer('book_id')->unsigned();
			$t->integer('merchant_id')->unsigned();
			$t->float('amount_used')->nullable();
			$t->float('amount_new')->nullable();
			$t->float('amount_rental')->nullable();
			$t->float('amount_ebook')->nullable();
			$t->float('amount_buyback')->nullable();
			$t->string('url_used')->nullable();
			$t->string('url_new')->nullable();
			$t->string('url_rental')->nullable();
			$t->string('url_ebook')->nullable();
			$t->string('url_buyback')->nullable();
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
