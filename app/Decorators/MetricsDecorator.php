<?php

namespace App\Decorators;

use App\Repositories\Metrics;
use App\Constants\metrics as MetricsConstants;
use App\Interfaces\UsersInterface;
use Illuminate\Support\Facades\DB;
use App\Interfaces\MetricsInterface;
use App\Http\Requests\Admin\Reports\ReportRequest;

class MetricsDecorator implements MetricsInterface
{
    private Metrics $metrics;
    private UsersInterface $users;

    public function __construct(Metrics $metrics, UsersInterface $users)
    {
        $this->metrics = $metrics;
        $this->users = $users;
    }
    /**
     * @return array
     */
    public function homeMetrics(): array
    {
        return [
            'metricsGeneral'  => $this->metrics->getMetricsAllOrders(),
            'metricsSeller'   => $this->metrics->getMetricsAdminOrders(),
            'metricsCategory' => $this->metrics->getMetricsCategory(),
            'pendingShipment' => $this->metrics->getpendingShipmentOrders(),
            'usersCount'      => $this->users->index()->count()
        ];
    }

    /**
     * @param ReportRequest $request
     * @return mixed
     */
    public function reports(ReportRequest $request)
    {
        $metricOrders = MetricsConstants::ORDERS;
        $metricSeller = MetricsConstants::SELLER;
        $from = $request->get('from', null);
        $until = $request->get('to', null);

        DB::unprepared("call orders_metrics_generate('$from', '$until', '$metricSeller', 'admin_id')");
        DB::unprepared("call orders_metrics_generate('$from', '$until', '$metricOrders', 'none')");
        DB::unprepared("call categories_metrics_generate('$from', '$until')");
    }
}
