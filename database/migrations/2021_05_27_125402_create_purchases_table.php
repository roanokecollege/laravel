<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier.purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("customer_id");
            $table->string("payment_intent_id");
            $table->string("charge_id");
            $table->float("charge_amount");
            $table->string("receipt_url");
            $table->RCFields();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashier.purchases');
    }
}
