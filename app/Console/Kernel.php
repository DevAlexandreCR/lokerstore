<?php

namespace App\Console;

use App\Console\Commands\AddMetricCategories;
use App\Console\Commands\CallMetrics;
use App\Console\Commands\CreateAdmin;
use App\Console\Commands\GenerateMonthlyReport;
use App\Console\Commands\QueryPayments;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        QueryPayments::class,
        CallMetrics::class,
        CreateAdmin::class,
        AddMetricCategories::class,
        GenerateMonthlyReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('payments:query')->everyThirtyMinutes();
        $schedule->command('category:metric')->cron('0 0 * * *'); // execute every days at 12:00 am
        $schedule->command('report:monthly')->cron('0 0 1 * *'); // execute every first day of month
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
