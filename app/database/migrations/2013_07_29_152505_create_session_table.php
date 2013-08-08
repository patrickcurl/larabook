<?php

use Illuminate\Database\Migrations\Migration;

class CreateSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sessions', function($t)
		{
			// We'll need to ensure that MySQL uses the InnoDB engine to
      // support the indexes, other engines aren't affected.
      $t->engine = 'InnoDB';
			$t->string('id')->unique();
			$t->text('payload');
			$t->integer('last_activity');
      $t->integer('user_id');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sessions');
	}

}
