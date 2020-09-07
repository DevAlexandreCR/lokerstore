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
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->nullable();
            $table->string('process_url')->nullable();
            $table->string('status')->default(PlaceToPay::PENDING);
            $table->string('reference')->nullable();
            $table->string('method')->nullable();
            $table->string('last_digit')->nullable();
            $table->unsignedBigInteger('order_id');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
