<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('owner_id')->unsigned();
			$table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
			$table->string('name', 320);
			$table->timestamps();
		});

		/*Schema::table('projects', function(Blueprint $table)
		{
			});
          */	
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('projects');
	}

}