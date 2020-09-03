<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBankaccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bankaccounts', function(Blueprint $table)
		{
			$table->foreign('BANKID', 'bankaccounts_ibfk_1')->references('id')->on('banks')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('USERID', 'bankaccounts_ibfk_2')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bankaccounts', function(Blueprint $table)
		{
			$table->dropForeign('bankaccounts_ibfk_1');
			$table->dropForeign('bankaccounts_ibfk_2');
		});
	}

}
