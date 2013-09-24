<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotFeatureMerchantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feature_merchant', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('feature_id')->unsigned()->index();
			$table->integer('merchant_id')->unsigned()->index();
			$table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
			$table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feature_merchant');
	}

}
