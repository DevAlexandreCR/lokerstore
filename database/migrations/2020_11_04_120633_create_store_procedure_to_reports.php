<?php

    use App\Constants\Procedures;
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Support\Facades\DB;

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
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_general_report_uncompleted');
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_monthly_report');
        DB::unprepared('DROP PROCEDURE IF EXISTS stock_report');
        DB::unprepared(Procedures::CATEGORIES_PROCEDURE);
        DB::unprepared(Procedures::ORDER_PROCEDURE);
        DB::unprepared(Procedures::GENERATE_CATEGORIES_REPORT);
        DB::unprepared(Procedures::GENERATE_GENERAL_REPORT);
        DB::unprepared(Procedures::GENERATE_GENERAL_REPORT_UNCOMPLETED);
        DB::unprepared(Procedures::GENERATE_MONTHLY_REPORT);
        DB::unprepared(Procedures::STOCK_REPORT);
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
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_monthly_report');
        DB::unprepared('DROP PROCEDURE IF EXISTS generate_general_report_uncompleted');
        DB::unprepared('DROP PROCEDURE IF EXISTS stock_report');
    }
}
