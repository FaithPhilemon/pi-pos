<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // prefixes
            $table->string('invoice_prefix')->default('INV');
            $table->string('supplier_prefix')->default('SPL');
            $table->string('customer_prefix')->default('CM');
            $table->string('sale_prefix')->default('SLS');
            $table->string('purchase_prefix')->default('PO');

            // payment
            $table->string('currency')->default('Naira (NGN)');
            $table->string('currency_symbol')->default('₦');
            $table->integer('enable_payments')->default(1);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
