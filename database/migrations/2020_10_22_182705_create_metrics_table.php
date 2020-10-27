<?php

    use Illuminate\Support\Facades\DB;
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
            $table->timestamps();
        });

        DB::unprepared('DROP PROCEDURE IF EXISTS orders_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS categories_metrics_generate');
        DB::unprepared(\App\Constants\Procedures::ORDER_PROCEDURE);
        DB::unprepared(\App\Constants\Procedures::CATEGORIES_PROCEDURE);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS orders_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS categories_metrics_generate');
        Schema::dropIfExists('metrics');
    }
}
