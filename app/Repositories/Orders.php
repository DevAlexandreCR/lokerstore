<?php

namespace App\Repositories;

use App\Constants\Orders as OrderConstants;
use App\Constants\Payments;
use App\Constants\PlaceToPay;
use App\Http\Requests\Admin\Orders\indexRequest;
use App\Http\Requests\Web\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Orders implements OrderInterface
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @param indexRequest $request
     * @return mixed
     */
    public function query(indexRequest $request)
    {
        $email = $request->get('email');
        $from = $request->get('from');
        $until = $request->get('until');
        $status = $request->get('status');

        return $this->order::with(['user'])
            ->status($status)
            ->userEmail($email)
            ->date($from, $until)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
    }

    public function index()
    {
        return $this->order::with('user')
            ->get();
    }

    /**
     * @param Request $request
     * @return Order
     */
    public function store(Request $request): Order
    {
        return $this->order->create($request->all());
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return Model|mixed
     */
    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    /**
     * @param Model $model
     */
    public function destroy(Model $model): void
    {
        $this->order::destroy($model->id);
    }

    /**
     * @param int $order_id
     * @return mixed
     */
    public function find(int $order_id)
    {
        return $this->order->load('payment')->findOrFail($order_id);
    }

    /**
     * @param int $order_id
     * @param string $status
     */
    public function setStatus(int $order_id, string $status): void
    {
        $order = $this->find($order_id);
        $order->update([
            'status' => $status,
        ]);
    }

    /**
     * @param string $status
     * @return string
     */
    public function getStatusFromStatusPayment(string $status): string
    {
        switch ($status) {
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

    /**
     * @param UpdateRequest $request
     */
    public function cancel(UpdateRequest $request): void
    {
        $order_id = $request->get('order_id', null);
        $order = $this->find($order_id);
        $payment = $order->payment;
        $payment->status = Payments::STATUS_CANCELED;
        $payment->save();
    }
}
