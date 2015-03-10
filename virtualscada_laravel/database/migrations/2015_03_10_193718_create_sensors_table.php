<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('sensors', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->string('name', 32);
            $table->string('data_loc', 320);

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('sensors');
	}

}
