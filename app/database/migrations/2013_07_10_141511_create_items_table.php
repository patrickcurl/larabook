<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $t)
		{
			// We'll need to ensure that MySQL uses the InnoDB engine to
      // support the indexes, other engines aren't affected.
      $t->engine = 'InnoDB';
			$t->increments('id');
			$t->unsignedInteger('book_id')->index();
			$t->unsignedInteger('order_id')->index();
			$t->integer('qty');
			$t->integer('price');
			$t->timestamps();
			$t->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$t->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('items');
	}

}
