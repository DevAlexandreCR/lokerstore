<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\UsersInterface;
use App\Http\Requests\Admin\Reports\ReportRequest;
use App\Interfaces\MetricsInterface;
use App\Models\Metric;
use Illuminate\Support\Facades\DB;

class Metrics implements MetricsInterface
{
    private Metric $metrics;
    private UsersInterface $users;

    public function __construct(Metric $metrics, UsersInterface $users)
    {
        $this->metrics = $metrics;
        $this->users = $users;
    }

    public function getMetricsAllOrders()
    {
        return $this->metrics->generalOrdersMetrics()->get();
    }

    public function getMetricsAdminOrders()
    {
        return $this->metrics->sellerOrdersMetrics()->get();
    }

    public function getMetricsCategory()
    {
        return $this->metrics->categorymoreSoldMetrics()->get();
    }

    public function getPendingShipmentOrders()
    {
        return Order::pendingShipmentOrders()->count();
    }

    public function getPercentMetrics()
    {
        return $this->metrics->percentMetrics()->get();
    }

    /**
     * @return array
     */
    public function homeMetrics(): array
    {
        return [
            'metricsGeneral'  => $this->getMetricsAllOrders(),
            'metricsSeller'   => $this->getMetricsAdminOrders(),
            'metricsCategory' => $this->getMetricsCategory(),
            'pendingShipment' => $this->getPendingShipmentOrders(),
            'percentMetrics' => $this->getPercentMetrics(),
            'usersCount'      => $this->users->index()->count(),
        ];
    }

    /**
     * @param ReportRequest $request
     * @return mixed
     */
    public function reports(ReportRequest $request)
    {
        $from = $request->get('from', null);
        $until = $request->get('to', null);

        return [
            'monthly' => DB::select("call generate_general_report('$from', '$until')"),
            'categories' => DB::select("call generate_categories_report('$from', '$until')"),
            'uncompleted' => DB::select("call generate_general_report_uncompleted('$from', '$until')"),
            'stocks' => DB::select('call stock_report()'),
        ];
    }

    /**
     * @param string $date
     * @param string $status
     * @return mixed
     */
    public function monthlyReport(string $date, string $status = '')
    {
        return DB::select("call generate_monthly_report('$date', '$status')");
    }

    /**
     * @return array
     */
    public function getStockReport(): array
    {
        return DB::select('call stock_report()');
    }
}
