<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookedflightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookedflights', function(Blueprint $table)
		{
			$table->foreign('USERID', 'bookedflights_ibfk_1')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('FLIGHTID', 'bookedflights_ibfk_2')->references('id')->on('flights')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bookedflights', function(Blueprint $table)
		{
			$table->dropForeign('bookedflights_ibfk_1');
			$table->dropForeign('bookedflights_ibfk_2');
		});
	}

}
