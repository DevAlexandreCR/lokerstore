<?php

namespace App\Observers;

use App\Models\OrderDetail;

class OrderDetailObserver
{
    /**
     * Handle the order detail "created" event.
     *
     * @param  OrderDetail  $orderDetail
     * @return void
     */
    public function created(OrderDetail $orderDetail): void
    {
        $stock = $orderDetail->stock;
        $stock->quantity -= $orderDetail->quantity;
        $stock->save();
    }

    /**
     * Handle the order detail "created" event.
     *
     * @param  OrderDetail  $orderDetail
     * @return void
     */
    public function updated(OrderDetail $orderDetail): void
    {
        $changes = $orderDetail->getChanges();
        $quantity = $changes['quantity'];
        $quantityOriginal = $orderDetail->getOriginal('quantity');

        $quantityToStock = $quantityOriginal - $quantity;
        $stock = $orderDetail->stock;
        $stock->quantity += $quantityToStock;
        $stock->save();
    }

    /**
     * @param OrderDetail $orderDetail
     */
    public function deleted(OrderDetail $orderDetail): void
    {
        $order = $orderDetail->order;
        $order->amount -= $orderDetail->total_price;

        $order->save();
    }
}
