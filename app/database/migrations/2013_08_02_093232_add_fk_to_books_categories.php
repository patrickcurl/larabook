<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFkToBooksCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('books_categories', function(Blueprint $t) {
			$t->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
			$t->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	/*	Schema::table('books_categories', function(Blueprint $t) {
			$t->dropForeign('books_categories_book_id_index');
			$t->dropForeign('books_categories_category_id_index');
		});
		*/
	}

}
