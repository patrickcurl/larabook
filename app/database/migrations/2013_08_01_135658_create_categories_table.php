<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $t) {
			// We'll need to ensure that MySQL uses the InnoDB engine to
      // support the indexes, other engines aren't affected.
      $t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('name')->unique();
			$t->string('description')->nullable();
			$t->boolean('visible')->default(1);
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

		Schema::drop('categories');
	}

}
