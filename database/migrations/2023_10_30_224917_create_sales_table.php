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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->dateTime('date');
            $table->string('phone_number')->nullable();
            $table->string('customer_name');
            $table->string('store')->default("Discovery World Bookshop");
            $table->string('payment_status');
            $table->string('payment_method');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('total_paid', 10, 2)->default(0);
            $table->integer('total_items')->nullable();
            $table->integer('shipping_status')->default(0);
            $table->text('shipping_details')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->string('staff_note')->nullable();
            $table->string('sale_note')->nullable();

            $table->foreign('added_by')->references('id')->on('users');
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
        Schema::dropIfExists('sales');
    }
};
