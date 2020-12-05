<?php

use App\Constants\Payments;
use App\Constants\PlaceToPay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->string('process_url')->nullable();
            $table->enum('status', Payments::getAllStatus())->default(PlaceToPay::PENDING);
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->string('last_digit')->nullable();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payer_id')->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('payments');
    }
}
