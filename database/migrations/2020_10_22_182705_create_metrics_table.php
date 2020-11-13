<?php

    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->enum('metric', \App\Constants\Metrics::toArray());
            $table->unsignedBigInteger('measurable_id')->nullable();
            $table->enum('status', \App\Constants\Orders::getAllStatus())->nullable();
            $table->integer('total')->default(0);
            $table->decimal('amount', 10, 2)->nullable();
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
        Schema::dropIfExists('metrics');
    }
}
