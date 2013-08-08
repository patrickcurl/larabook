<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $t) {
            // We'll need to ensure that MySQL uses the InnoDB engine to
            // support the indexes, other engines aren't affected.
            $t->engine = 'InnoDB';
            $t->increments('id');
            $t->string('first_name', 50)->nullable();
			$t->string('last_name', 50)->nullable();
            $t->string('email', 255)->index();
			$t->string('password');
            $t->string('phone', 20);
			$t->string('address', 50);
			$t->string('city', 50);
			$t->string('state', 10);
			$t->string('zip', 10);
			$t->string('payment_method', 20);
			$t->string('paypal_email')->nullable();
            $t->string('name_on_cheque')->nullable();
			$t->text('permissions')->nullable();
            $t->boolean('activated')->default(0);
            $t->string('activation_code')->nullable();
            $t->timestamp('activated_at')->nullable();
            $t->timestamp('last_login')->nullable();
            $t->string('persist_code')->nullable();
            $t->string('reset_password_code')->nullable();
            $t->timestamps();

            // Indexes
            $t->unique('email');
            $t->index('activation_code');
            $t->index('reset_password_code');

        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }

}
