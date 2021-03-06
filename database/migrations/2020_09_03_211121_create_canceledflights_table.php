<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCanceledflightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('canceledflights', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('BOOKEDFLIGHTID')->unsigned()->index('BOOKEDFLIGHTID');
			$table->string('ADESCRIPTION', 500)->nullable();
			$table->string('EDESCRIPTION', 500)->nullable();
			$table->timestamp('CREATED_AT')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('UPDATED_AT')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('canceledflights');
	}

}
