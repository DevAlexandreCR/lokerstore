<?php

namespace App\Console\Commands;

use App\Constants\Metrics;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CallMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metrics:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call procedures to charge metrics in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $metricOrders = Metrics::ORDERS;
        $metricSeller = Metrics::SELLER;
        $from = now()->subYear()->format('Y-m-d');
        $until = now()->format('Y-m-d');
        $firstMonth = now()->subMonth();
        DB::unprepared("call orders_metrics_generate('$firstMonth', '$until', '$metricSeller', 'admin_id')");
        DB::unprepared("call orders_metrics_generate('$from', '$until', '$metricOrders', 'none')");
        DB::unprepared("call categories_metrics_generate('$firstMonth', '$until')");

        $this->info(trans('messages.crud', [
            'resource' => trans('fields.metrics'),
            'status' => trans('fields.updated')
        ]));
    }
}
