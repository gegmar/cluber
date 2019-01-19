<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('price_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });

        Schema::create('price_category_price_list', function (Blueprint $table) {
            $table->unsignedInteger('price_list_id');
            $table->unsignedInteger('price_category_id');

            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->foreign('price_category_id')->references('id')->on('price_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('price_categories_price_lists');
        Schema::drop('price_categories');
        Schema::dropIfExists('price_lists');
    }
}
