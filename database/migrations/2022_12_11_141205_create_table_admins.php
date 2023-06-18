<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAdmins extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admins', function (Blueprint $table) {
			$table->id();
			$table->string('fullname')->nullable();
			$table->string('email')->unique();
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->string('show_password')->nullable();
			$table->tinyInteger('status');
			$table->integer('mobile_code')->nullable();
			$table->string('mobile')->nullable();
			$table->string('staff_access')->nullable();
			$table->string('photo')->nullable();
			$table->string('photo_url')->nullable();
			$table->rememberToken();
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
		Schema::dropIfExists('admins');
	}
}
