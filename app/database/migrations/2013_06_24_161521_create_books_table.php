<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('books', function(Blueprint $t)
		{
			// We'll need to ensure that MySQL uses the InnoDB engine to
      // support the indexes, other engines aren't affected.
      $t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('title');
			$t->string('author')->nullable();
			$t->string('publisher')->nullable();
			$t->string('image_url')->nullable();
			$t->string('isbn10')->unique();
			$t->string('isbn13')->unique();
			$t->string('amazon_url')->nullable();
			$t->string('edition')->nullable();
			$t->integer('num_of_pages')->nullable();
			$t->float('list_price')->nullable();
			$t->float('weight')->nullable();
			$t->text('editorial_review')->nullable();
			$t->text('customer_reviews')->nullable();
			$t->string('slug')->unique();
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
		Schema::drop('books');
	}

}
