<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\OrderDetailInterface;
use App\Models\OrderDetail;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class OrderDetails implements OrderDetailInterface
{
    protected OrderDetail $orderDetail;

    public function __construct(OrderDetail $orderDetail)
    {
        $this->orderDetail = $orderDetail;
    }

    /**
     * @param int $order_id
     * @return mixed|void
     */
    public function createFromUser(int $order_id)
    {
        $cart = Auth::user()->cart;

        $cart->stocks->each(function ($stock) use ($order_id) {
            $this->orderDetail->create([
                'order_id' => $order_id,
                'stock_id' => $stock->id,
                'quantity' => $stock->pivot->quantity,
                'unit_price' => $stock->product->price,
                'total_price' => $stock->product->price * $stock->pivot->quantity,
            ]);
        });

        $order = Order::findOrFail($order_id);
        $order->amount = 0;
        $order->orderDetails->each(function ($detail) use ($order) {
            $order->amount += $detail->total_price;
        });
        $order->save();
        $cart->emptyCart();
    }

    /**
     * Create detail to to order from admin Controller
     * @param int $order_id
     * @param int $stock_id
     * @param int $quantity
     * @return mixed
     */
    public function createFromAdmin(int $order_id, int $stock_id, int $quantity): void
    {
        $stock = Stock::findOrFail($stock_id);

        $this->orderDetail->create([
            'order_id' => $order_id,
            'stock_id' => $stock->id,
            'quantity' => $quantity,
            'unit_price' => $stock->product->price,
            'total_price' => $stock->product->price * $quantity,
        ]);
    }
}
