<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellStopsToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('customer_sell_stop')->default('9999-12-31 23:55:55');
            $table->dateTime('retailer_sell_stop')->default('9999-12-31 23:55:55');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('retailer_sell_stop');
            $table->dropColumn('customer_sell_stop');
        });
    }
}
