<?php

namespace App\Repositories;

use App\Constants\Orders as OrderConstants;
use App\Constants\PlaceToPay;
use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Constants\Payments;
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
        return $this->order::all();
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

    public function find(int $order_id)
    {
        return $this->order->load('payment')->findOrFail($order_id);
    }

    public function setStatus(int $order_id, string $status)
    {
        $order = $this->find($order_id);
        $order->update([
            'status' => $status
        ]);
    }

    public function getStatusFromStatusPayment(string $status): string
    {
        switch ($status)
        {
            case PlaceToPay::FAILED:
                return OrderConstants::STATUS_FAILED;
            case PlaceToPay::REJECTED:
                return OrderConstants::STATUS_REJECTED;
            case PlaceToPay::APPROVED:
                return OrderConstants::STATUS_PENDING_SHIPMENT;
            case Payments::STATUS_CANCELED:
                return OrderConstants::STATUS_CANCELED;
            default:
                return OrderConstants::STATUS_PENDING_PAY;
        }
    }

    public function getRequestInformation(int $order_id)
    {
        // TODO: Implement destroy() method.
    }

    public function resend(UpdateRequest $request)
    {
        // TODO: Implement destroy() method.
    }

    public function reverse(UpdateRequest $request)
    {
        // TODO: Implement reverse() method.
    }
}
