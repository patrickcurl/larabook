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
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 50);
			$table->string('last_name', 50);
			$table->string('username', 50)->index();
            $table->string('email', 255)->index();
			$table->string('password', 50)->index();
			$table->string('salt', 32);
			$table->string('phone', 20);
			$table->string('address', 50);
			$table->string('city', 50);
			$table->string('state', 10);
			$table->string('zip', 10);
			$table->string('payment_method', 20);
			$table->string('paypal_email')->nullable();
			$table->boolean('verified')->default(0);
			$table->boolean('disabled')->default(0);;
			$table->boolean('deleted')->default(0);
            $table->timestamps();
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
