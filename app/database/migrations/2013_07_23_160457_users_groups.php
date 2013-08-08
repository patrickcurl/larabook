<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UsersGroups extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_groups', function(Blueprint $t) {
            // We'll need to ensure that MySQL uses the InnoDB engine to
            // support the indexes, other engines aren't affected.
            $t->engine = 'InnoDB';
            $t->increments('id');
            $t->unsignedInteger('user_id')->index();
            $t->unsignedInteger('group_id')->index();

            //$t->primary(array('user_id', 'group_id'));


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_groups');
    }

}
