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
        Schema::table('sales', function (Blueprint $table) {
            // Delete 
            $table->dropColumn(['payment_status', 'payment_method', 'shipping_status']);

            // Add the foreign key for Sale or Order Status
            $table->after('store', function (Blueprint $table) {
                $table->unsignedBigInteger('sale_status_id')->nullable();
                $table->foreign('sale_status_id')->references('id')->on('sale_statuses');

                // Add foreign keys for Payment Status, Payment Method, and Shipping Status
                $table->unsignedBigInteger('payment_status_id')->nullable();
                $table->foreign('payment_status_id')->references('id')->on('payment_statuses');

                $table->unsignedBigInteger('payment_method_id')->nullable();
                $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            });


            $table->after('total_items', function (Blueprint $table) {
                $table->unsignedBigInteger('shipping_status_id')->nullable();
                $table->foreign('shipping_status_id')->references('id')->on('shipping_statuses');
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['sale_status_id']);
            $table->dropForeign(['payment_status_id']);
            $table->dropForeign(['payment_method_id']);
            $table->dropForeign(['shipping_status_id']);

            $table->dropColumn(['sale_status_id', 'payment_status_id', 'payment_method_id', 'shipping_status_id']);
        });
    }
};
