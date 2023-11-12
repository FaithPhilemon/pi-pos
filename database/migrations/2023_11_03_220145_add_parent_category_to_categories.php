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
        Schema::table('categories', function (Blueprint $table) {
            $table->after('code', function (Blueprint $table) {
                $table->unsignedBigInteger('sub_category_id')->nullable();
                $table->foreign('parent_category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('CASCADE')
                    ->onUpdate('CASCADE'); // Specify cascading delete
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
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn('sub_category_id');
        });
    }
};
