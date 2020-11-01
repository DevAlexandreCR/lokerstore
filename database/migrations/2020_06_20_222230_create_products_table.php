<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('reference')->unique();
            $table->string('name');
            $table->string('description');
            $table->integer('stock')->default(0)->unsigned();
            $table->unsignedBigInteger('id_category');
            $table->decimal('cost', 8, 2);
            $table->decimal('price', 8, 2);
            $table->foreign('id_category')->references('id')->on('categories');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
