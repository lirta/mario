<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntriansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('antrians', function (Blueprint $table) {
			$table->id();
			$table->date("tanggal");
			$table->string("no_antrian");
			$table->string('member_id');
			$table->integer('id_layanan');
			$table->time('start');
			$table->time('finish');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('antrians');
	}
}
