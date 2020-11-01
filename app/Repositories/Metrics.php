<?php


namespace App\Repositories;


use App\Models\Metric;
use App\Interfaces\MetricsInterface;
use App\Http\Requests\Admin\Reports\ReportRequest;

class Metrics implements MetricsInterface
{
    private Metric $metrics;

    public function __construct(Metric $metrics)
    {
        $this->metrics = $metrics;
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

    public function getpendingShipmentOrders()
    {
        return $this->metrics->pendingShipmentOrders()->get()->count();
    }

    /**
     * @return array
     */
    public function homeMetrics(): array
    {
        // TODO: Implement homeMetrics() method.
    }

    /**
     * @param ReportRequest $request
     * @return mixed
     */
    public function reports(ReportRequest $request)
    {
        // TODO: Implement reports() method.
    }
}
