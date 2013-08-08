<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class BooksCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('books_categories', function(Blueprint $t) {
			// We'll need to ensure that MySQL uses the InnoDB engine to
      // support the indexes, other engines aren't affected.
      $t->engine = 'InnoDB';
			$t->increments('id');
			$t->unsignedInteger('book_id')->index();
      $t->unsignedInteger('category_id')->index();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('books_categories', function(Blueprint $t) {
			$t->dropForeign('books_categories_book_id_foreign');
			$t->dropForeign('books_categories_category_id_foreign');

		});
		Schema::drop('books_categories');
	}

}
