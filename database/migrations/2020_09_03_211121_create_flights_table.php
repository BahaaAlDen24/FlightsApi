<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFlightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flights', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('FROMID')->unsigned()->index('FROMID');
			$table->bigInteger('TOID')->unsigned()->index('TOID');
			$table->bigInteger('AIRPLANEID')->unsigned()->index('AIRPLANEID');
			$table->bigInteger('AIRLINEID')->unsigned()->index('AIRLINEID');
			$table->bigInteger('FLIGHTTYPEID')->unsigned()->index('FLIGHTTYPEID');
			$table->dateTime('ARRIVALTIME');
			$table->dateTime('DEPATURETIME');
			$table->integer('TOTALSEATNUMBER')->nullable();
			$table->integer('AVAILABLESEATNUMBER')->nullable();
			$table->integer('PRICE')->nullable();
			$table->string('ADESCRIPTION', 500)->nullable();
			$table->string('EDESCRIPTION', 500)->nullable();
			$table->string('IMGSRC1', 500)->nullable();
			$table->string('IMGSRC2', 500)->nullable();
			$table->string('IMGSRC3', 500)->nullable();
			$table->string('IMGSRC4', 500)->nullable();
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
		Schema::drop('flights');
	}

}
