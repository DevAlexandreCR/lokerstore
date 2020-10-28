<?php

namespace App\Http\Controllers\Admin;

use App\Models\Metric;
use App\Constants\Orders;
use App\Constants\Metrics;
use App\Interfaces\UsersInterface;
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
     * @param UsersInterface $users
     * @return View
     */
    public function index(UsersInterface $users): View
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
        DB::unprepared("call categories_metrics_generate('$firstMonth', '$until')");

        return view('admin.stats', [
            'metricsGeneral'  => $this->metrics->getMetricsAllOrders(),
            'metricsSeller'   => $this->metrics->getMetricsAdminOrders(),
            'metricsCategory' => $this->metrics->getMetricsCategory(),
            'pendingShipment' => $this->metrics->getpendingShipmentOrders(),
            'usersCount'      => $users->index()->count()
        ]);
    }
}
