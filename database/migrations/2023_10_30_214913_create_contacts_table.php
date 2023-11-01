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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('contact_name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('contact_group')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->text('address')->nullable();

            $table->foreign('contact_group')->references('id')->on('contact_groups');
            $table->foreign('assigned_to')->references('id')->on('users');
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
        Schema::dropIfExists('contacts');
    }
};
