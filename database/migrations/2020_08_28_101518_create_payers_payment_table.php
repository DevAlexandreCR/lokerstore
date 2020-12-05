<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayersPaymentTable extends Migration
{
    /**
     * Create table payers
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payers', function (Blueprint $table) {
            $table->id();
            $table->string('document')->nullable();
            $table->string('document_type')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations of table payers.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('payers');
    }
}
