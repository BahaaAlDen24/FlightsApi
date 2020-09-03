<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAirportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('airports', function(Blueprint $table)
		{
			$table->foreign('CITYID', 'airports_ibfk_1')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('airports', function(Blueprint $table)
		{
			$table->dropForeign('airports_ibfk_1');
		});
	}

}
