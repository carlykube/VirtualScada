<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualMachinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('virtual_machines', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name', 32);
            $table->string('file_loc', 320);
            $table->string('screen_loc', 32);
            $table->timestamps();

            // foreign keys
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('virtual_machines');
	}

}
