<?php

namespace App\Repositories;

use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Constants\Payments;

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

    public function store(Request $request): Order
    {
        return $this->order->create($request->all());
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    public function destroy(Model $model): void
    {
        $model->delete();
    }

    public function find(int $user_id, int $order_id): Model
    {
        return $this->order->with('payment')->find($order_id);
    }

    public function getRequestInformation(UpdateRequest $request)
    {
        $status = $request->get('status', Payments::STATUS_PENDING);
        $order = $this->find($request->user()->id, $request->get('order_id', null));
        $order->status = $status;
        $order->save();
    }
}
