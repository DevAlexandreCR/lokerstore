<?php

namespace App\Actions\Metrics;

use App\Models\Metric;
use App\Models\Order;

class RemoveMetricOrders
{
    public static function execute(Order $order): void
    {
        $date = date('Y-m-d', strtotime($order->created_at));

        $metric = Metric::whereDate('date', '=', $date)->get();

        if ($metric->amount) {
            $metric->amount = $metric->amount ?? 0 - (float)$order->amount;
            $metric->total = $metric->total ?? 0 - 1;
            $metric->save();
        }
    }
}
