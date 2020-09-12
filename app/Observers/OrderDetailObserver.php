<?php

namespace App\Observers;

use App\Models\OrderDetail;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderDetailObserver implements ShouldQueue
{
    /**
     * Handle the order detail "created" event.
     *
     * @param  OrderDetail  $orderDetail
     * @return void
     */
    public function created(OrderDetail $orderDetail)
    {
        $stock = $orderDetail->stock;
        $stock->quantity -= $orderDetail->quantity;
        $stock->save();
    }
}
