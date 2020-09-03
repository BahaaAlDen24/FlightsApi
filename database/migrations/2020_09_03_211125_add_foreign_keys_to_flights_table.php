<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFlightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flights', function(Blueprint $table)
		{
			$table->foreign('FROMID', 'flights_ibfk_1')->references('id')->on('airports')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('TOID', 'flights_ibfk_2')->references('id')->on('airports')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('AIRPLANEID', 'flights_ibfk_3')->references('id')->on('airplanes')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('AIRLINEID', 'flights_ibfk_4')->references('id')->on('airlines')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('FLIGHTTYPEID', 'flights_ibfk_5')->references('id')->on('flighttypes')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flights', function(Blueprint $table)
		{
			$table->dropForeign('flights_ibfk_1');
			$table->dropForeign('flights_ibfk_2');
			$table->dropForeign('flights_ibfk_3');
			$table->dropForeign('flights_ibfk_4');
			$table->dropForeign('flights_ibfk_5');
		});
	}

}
