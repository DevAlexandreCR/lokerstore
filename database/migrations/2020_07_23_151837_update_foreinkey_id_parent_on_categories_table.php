<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeinkeyIdParentOnCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['id_parent']);
            $table->unsignedBigInteger('id_parent')->nullable()->change();

            $table->foreign('id_parent')->references('id')->on('categories')->onDelete('cascade');
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
            $table->dropForeign(['id_parent']);
            $table->unsignedBigInteger('id_parent')->change();

            $table->foreign('id_parent')->references('id')->on('categories');
        });
    }
}
