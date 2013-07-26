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
            $table->string('first_name', 50)->nullable();
			$table->string('last_name', 50)->nullable();
            $table->string('email', 255)->index();
			$table->string('password');
            $table->string('phone', 20);
			$table->string('address', 50);
			$table->string('city', 50);
			$table->string('state', 10);
			$table->string('zip', 10);
			$table->string('payment_method', 20);
			$table->string('paypal_email')->nullable();
            $table->string('name_on_cheque')->nullable();
			$table->text('permissions')->nullable();
            $table->boolean('activated')->default(0);
            $table->string('activation_code')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('persist_code')->nullable();
            $table->string('reset_password_code')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->unique('email');
            $table->index('activation_code');
            $table->index('reset_password_code');
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
