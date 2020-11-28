<?php

namespace App\Actions\Stocks;

use App\Constants\Metrics;
use App\Constants\Orders;
use App\Models\Metric;
use App\Models\Order;

class ReturnStockAction
{
    public static function execute(Order $order): void
    {
        $order->orderDetails->each(function ($detail) {
            $stock = $detail->stock;
            $stock->quantity += $detail->quantity;
            $stock->save();
        });
    }
}
