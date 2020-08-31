<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Orders implements OrderInterface
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        return $this->order->all();
    }

    public function store(Request $request)
    {
        return $this->order->create($request->all());
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    public function destroy(Model $model)
    {
        $model->delete();
    }

    public function find(int $user_id, int $order_id)
    {
        return $this->order->with('payment')->find($order_id);
    }
}
