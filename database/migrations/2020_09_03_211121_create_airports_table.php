<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAirportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('airports', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('CITYID')->unsigned()->index('CITYID');
			$table->string('ANAME', 200)->nullable();
			$table->string('ENAME', 200);
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
		Schema::drop('airports');
	}

}
