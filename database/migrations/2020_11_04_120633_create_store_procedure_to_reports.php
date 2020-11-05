<?php

    use Illuminate\Support\Facades\DB;
    use Illuminate\Database\Migrations\Migration;

class CreateStoreProcedureToReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_categories_report');
        DB::unprepared('DROP PROCEDURE IF EXISTS orders_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS categories_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_general_report');
        DB::unprepared(\App\Constants\Procedures::ORDER_PROCEDURE);
        DB::unprepared(\App\Constants\Procedures::CATEGORIES_PROCEDURE);
        DB::unprepared(\App\Constants\Procedures::GENERATE_CATEGORIES_REPORT);
        DB::unprepared(\App\Constants\Procedures::GENERATE_GENERAL_REPORT);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_categories_report');
        DB::unprepared('DROP PROCEDURE IF EXISTS orders_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS categories_metrics_generate');
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_general_report');
    }
}
