<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Throttle extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('throttle', function(Blueprint $t) {
            // We'll need to ensure that MySQL uses the InnoDB engine to
            // support the indexes, other engines aren't affected.
            $t->engine = 'InnoDB';
            $t->increments('id');
            $t->integer('user_id')->unsigned();
            $t->string('ip_address')->nullable();
            $t->integer('attempts')->default(0);
            $t->boolean('suspended')->default(0);
            $t->boolean('banned')->default(0);
            $t->timestamp('last_attempt_at')->nullable();
            $t->timestamp('suspended_at')->nullable();
            $t->timestamp('banned_at')->nullable();


        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('throttle');
    }

}
