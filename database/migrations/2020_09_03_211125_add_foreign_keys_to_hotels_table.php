<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHotelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('hotels', function(Blueprint $table)
		{
			$table->foreign('CITYID', 'hotels_ibfk_1')->references('id')->on('cities')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('hotels', function(Blueprint $table)
		{
			$table->dropForeign('hotels_ibfk_1');
		});
	}

}
