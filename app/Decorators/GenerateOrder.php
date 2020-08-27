<?php

namespace App\Decorators;

use App\Interfaces\OrderInterface;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class GenerateOrder implements OrderInterface
{
    protected $orders;
    protected $orderDetails;

    public function __construct(Orders $orders, OrderDetails $orderDetails)
    {
        $this->orders = $orders;
        $this->orderDetails = $orderDetails;
    }

    public function index()
    {
        return $this->orders->index();
    }

    public function store(Request $request)
    {
        $order = $this->orders->store($request);

        $this->orderDetails->create($order->id);

        $order->orderDetails->each(function ($detail) use($order){
            $order->order_price += $detail->total_price;
        });

        $order->save();

    }

    public function update(Request $request, Model $model)
    {
        // TODO: Implement update() method.
    }

    public function destroy(Model $model)
    {
        // TODO: Implement destroy() method.
    }
}
