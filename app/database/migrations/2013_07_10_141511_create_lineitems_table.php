<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lineitems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('book_id')->unsigned();
			$table->integer('order_id')->unsigned();
			$table->integer('qty');
			$table->integer('price');
			$table->timestamps();
			$table->foreign('book_id')->references('id')->on('books');
			$table->foreign('order_id')->references('id')->on('orders');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lineitems');
	}

}
