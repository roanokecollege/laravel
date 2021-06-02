<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier.purchase_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("fkey_purchase_id");
            $table->string("fkey_price_id");
            $table->integer("quantity");
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
        Schema::dropIfExists('cashier.purchase_items');
    }
}
