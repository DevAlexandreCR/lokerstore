<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Metrics;
use App\Repositories\Metrics as MetricsRepo;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    private MetricsRepo $metrics;

    public function __construct(MetricsRepo $metrics)
    {
        $this->metrics = $metrics;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $metricOrders = Metrics::ORDERS;
        $metricSeller = Metrics::SELLER;
        $from = now()->subYear()->format('Y-m-d');
        $until = now()->format('Y-m-d');
        $month = date('m');
        $year = date('Y');
        $firstMonth = date('Y-m-d', mktime(0,0,0, $month, 1, $year));
        DB::unprepared("call orders_metrics_generate('$firstMonth', '$until', '$metricSeller', 'admin_id')");
        DB::unprepared("call orders_metrics_generate('$from', '$until', '$metricOrders', 'none')");

        return view('admin.stats', [
            'metricsGeneral' => $this->metrics->getMetricsAllOrders(),
            'metricsSeller'  => $this->metrics->getMetricsAdminOrders()
        ]);
    }
}
