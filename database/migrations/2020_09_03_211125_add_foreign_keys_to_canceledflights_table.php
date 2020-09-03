<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCanceledflightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('canceledflights', function(Blueprint $table)
		{
			$table->foreign('BOOKEDFLIGHTID', 'canceledflights_ibfk_1')->references('id')->on('bookedflights')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('canceledflights', function(Blueprint $table)
		{
			$table->dropForeign('canceledflights_ibfk_1');
		});
	}

}
