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
        Schema::table('products', function (Blueprint $table) {
            $table->after('name', function (Blueprint $table) {
                $table->string('author')->nullable();
                $table->string('ISBN')->nullable();
            });


            $table->after('image', function (Blueprint $table) {
                $table->string('qr_code')->nullable();
                $table->string('barcode')->nullable();
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['author', 'ISBN', 'qr_code', 'barcode']);
        });
    }
};
