<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddMetricCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:metric';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call procedure to add categories metric';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $until = now()->format('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $firstDayOfMonth = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
        DB::unprepared("call categories_metrics_generate('$firstDayOfMonth', '$until')");

        $this->info('Metrics updated successfully!');
    }
}
