<?php

namespace App\Actions\Metrics;

use App\Constants\Metrics;
use App\Constants\Orders;
use App\Models\Metric;
use App\Models\Order;

class AddMetricOrders
{
    public static function execute(Order $order): void
    {
        $date = date('Y-m-d', strtotime($order->created_at));
        $status = $order->status;
        if ($status === Orders::STATUS_REJECTED) {
            $status = Orders::STATUS_CANCELED;
        }
        $metric = Metric::firstorCreate([
            'date'   => $date,
            'metric' => Metrics::ORDERS,
            'status' => $status,
            'measurable_id' => null,
        ]);
        $metric->amount = $metric->amount ?? 0 + (float)$order->amount;
        $metric->total = $metric->total ?? 0 + 1;

        $metric->save();
    }
}
