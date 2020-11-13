<?php

namespace App\Observers;

use App\Actions\Metrics\AddMetricOrders;
use App\Actions\Metrics\AddMetricSellers;
use App\Constants\Logs;
use App\Constants\Orders;
use App\Jobs\SendEmailUsers;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the order "updated" event.
     *
     * @param  Order  $order
     * @return void
     */
    public function updated(Order $order): void
    {
        $status = $order->status;
        if (array_key_exists('status', $order->getChanges()) &&
            in_array($status, [
                Orders::STATUS_SUCCESS,
                Orders::STATUS_SENT,
                Orders::STATUS_REJECTED,
                Orders::STATUS_CANCELED,
            ], true)) {
            AddMetricOrders::execute($order);
            if ($status === Orders::STATUS_SENT || $status === Orders::STATUS_SUCCESS) {
                AddMetricSellers::execute($order);
            }
        }

        switch ($status) {
            case Orders::STATUS_PENDING_SHIPMENT:
                logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Payment ' . $order->payment->id .
                ' has been success');
                SendEmailUsers::dispatch($order);
                break;
            case Orders::STATUS_CANCELED:
                logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Order ' . $order->id .
                    ' has been canceled, updating stocks ...');
                $order->orderDetails->each(function ($detail) {
                    $stock = $detail->stock;
                    $stock->quantity += $detail->quantity;
                    $stock->save();
                });
                break;
        }
    }
}
