<?php


namespace App\Repositories;


use App\Models\Metric;

class Metrics
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
}
