<?php

namespace App\Repositories;

use App\Interfaces\OrderDetailInterface;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderDetails implements OrderDetailInterface
{
    protected $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    public function create(int $order_id)
    {
        $cart = Auth::user()->cart;

        $cart->stocks->each(function ($stock) use ($order_id) {
            $this->orderDetail->create([
                'order_id' => $order_id,
                'product_id' => $stock->product_id,
                'color_id' => $stock->color_id,
                'size_id' => $stock->size_id,
                'quantity' => $stock->pivot->quantity,
                'unit_price' => $stock->product->price,
                'total_price' => $stock->product->price * $stock->pivot->quantity
            ]);
        });

        $cart->emptyCart();
    }
}
