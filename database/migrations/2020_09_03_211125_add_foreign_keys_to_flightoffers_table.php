<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFlightoffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flightoffers', function(Blueprint $table)
		{
			$table->foreign('OFFERID', 'flightoffers_ibfk_1')->references('id')->on('offers')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('FLIGHTID', 'flightoffers_ibfk_2')->references('id')->on('flights')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flightoffers', function(Blueprint $table)
		{
			$table->dropForeign('flightoffers_ibfk_1');
			$table->dropForeign('flightoffers_ibfk_2');
		});
	}

}
