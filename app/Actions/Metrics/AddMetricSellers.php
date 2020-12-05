<?php

namespace App\Actions\Metrics;

use App\Constants\Metrics;
use App\Models\Metric;
use App\Models\Order;
use Illuminate\Support\Facades\Date;

class AddMetricSellers
{
    public static function execute(Order $order): void
    {
        $date = date('Y-m-d', strtotime($order->created_at));
        $metric = Metric::firstorCreate([
            'date'   => $date,
            'metric' => Metrics::SELLER,
            'measurable_id' => $order->admin_id,
        ]);
        $metric->status = $order->status;
        $metric->amount = $metric->amount ?? 0 + (float)$order->amount;
        $metric->total = $metric->total ?? 0 + 1;

        $metric->save();
    }
}
