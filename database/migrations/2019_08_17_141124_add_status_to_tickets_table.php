<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToTicketsTable extends Migration
{
    /**
     * Run the migrations and add a state column to the tickets table
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('state', 10)->default('consumed'); // possible states: 'no_show' (= Ticket was not consumed) and 'consumed'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
}
