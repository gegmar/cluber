<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('second_name');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('location_id');
            $table->unsignedInteger('seat_map_id');
            $table->unsignedInteger('price_list_id');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('seat_map_id')->references('id')->on('seat_maps');
            $table->foreign('price_list_id')->references('id')->on('price_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
