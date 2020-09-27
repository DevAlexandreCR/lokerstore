<?php

namespace App\Observers;

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

        switch ($status) {
            case Orders::STATUS_PENDING_SHIPMENT:
                logger()->channel(Logs::CHANNEL_PAYMENTS)->info('Payment ' . $order->payment->id .
                ' has been success');
                dispatch(new SendEmailUsers($order));
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
