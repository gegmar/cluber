<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentIdToPurchases extends Migration
{
    /**
     * Run the migrations.
     * 
     * Add the field "payment_id" to the table purchases. Must be a string with default length,
     * because it should store all kinds of payment_ids of different kind of payment providers.
     * 
     * It will store payment_ids that are returned by payment providers on creation of
     * payment-urls. They are used to track and identify purchases processed by the payment provider.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('payment_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('payment_id');
        });
    }
}
