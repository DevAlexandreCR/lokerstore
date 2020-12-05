<?php

namespace App\Observers;

use App\Actions\Metrics\AddMetricOrders;
use App\Actions\Metrics\AddMetricSellers;
use App\Constants\Logs;
use App\Constants\Orders;
use App\Jobs\SendEmailUsers;
use App\Models\Order;
use App\Actions\Stocks\ReturnStockAction;
use App\Actions\Metrics\RemoveMetricOrders;

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

        switch ($status) {
            case Orders::STATUS_PENDING_SHIPMENT:
                logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Payment ' . $order->payment->id .
                ' has been success');
                if ($order->user) {
                    SendEmailUsers::dispatch($order);
                }
                break;
            case Orders::STATUS_CANCELED:
                logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Order ' . $order->id .
                    ' has been canceled, updating stocks ...');
                if ($order->getChanges()['status'] === Orders::STATUS_SUCCESS) {
                    RemoveMetricOrders::execute($order);
                }
                ReturnStockAction::execute($order);
                AddMetricOrders::execute($order);
                break;
            case Orders::STATUS_SUCCESS:
                AddMetricSellers::execute($order);
                AddMetricOrders::execute($order);
                break;
        }
    }
}
