<?php

namespace App\Decorators;

use App\Constants\Orders as OrderConstants;
use App\Constants\Payments as Pay;
use App\Constants\PlaceToPay;
use App\Http\Requests\Web\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Repositories\Payments;
use App\Traits\HttpClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GenerateOrder implements OrderInterface
{
    use HttpClient;

    protected Orders $orders;
    protected OrderDetails $orderDetails;
    protected Payments $payments;

    public function __construct(Orders $orders, OrderDetails $orderDetails, Payments $payments)
    {
        $this->orders = $orders;
        $this->orderDetails = $orderDetails;
        $this->payments = $payments;
    }

    public function index()
    {
        return $this->orders->index();
    }

    public function store(Request $request)
    {
        $order = $this->orders->store($request);

        $this->orderDetails->createFromUser($order->id);

        $order->orderDetails->each(function ($detail) use ($order) {
            $order->amount += $detail->total_price;
        });

        $order->save();

        $response = $this->sendRequest(PlaceToPay::CREATE_REQUEST, $order);

        return $this->responseHandler($response, $order);
    }

    public function update(Request $request, Model $model)
    {
        // TODO: Implement update() method.
    }

    public function destroy(Model $model)
    {
        // TODO: Implement destroy() method.
    }

    public function responseHandler($response, Order $order): RedirectResponse
    {
        $status = $response->status->status;
        switch ($status) {
            case PlaceToPay::OK:
                $requestId = $response->requestId;
                $processUrl = $response->processUrl;
                $this->payments->create($order->id, $requestId, $processUrl);

                return redirect()->away($processUrl)->send();
            case PlaceToPay::PENDING:
                $message = trans('payment.messages.pending_recent');
                break;
            case PlaceToPay::APPROVED:
                if ($response->status->message === PlaceToPay::MESSAGE_REVERSED) {
                    $this->payments->setStatus($order->payment, Pay::STATUS_CANCELED);
                    $message = trans('payment.messages.reversed');
                } else {
                    $this->payments->setStatus($order->payment, $status);
                    $this->payments->setDataPayment($order->payment, $response);
                    $message = trans('payment.messages.pay_accepted');
                }
                break;
            case PlaceToPay::REJECTED:
                $this->payments->setStatus($order->payment, $status);
                $message = trans('payment.messages.rejected');
                break;
            default:
                $this->payments->create($order->id, null, null);
                $this->payments->setStatus($order->payment, Pay::FAILED);
                $message = $response->status->message;
        }

        return redirect()->to(route('user.order.show', [auth()->id(), $order->refresh()->id]))
            ->with('message', $message);
    }

    public function find(int $order_id)
    {
        return $this->orders->find($order_id);
    }

    public function getRequestInformation(int $order_id): RedirectResponse
    {
        $order = $this->orders->find($order_id);
        $response = $this->sendRequest(PlaceToPay::GET_REQUEST_INFORMATION, $order);

        return $this->responseHandler($response, $order);
    }

    public function resend(UpdateRequest $request): RedirectResponse
    {
        $order_id = $request->get('order_id', null);
        $order = $this->orders->find($order_id);

        $response = $this->sendRequest(PlaceToPay::CREATE_REQUEST, $order);

        return $this->responseHandler($response, $order);
    }

    public function reverse(UpdateRequest $request)
    {
        $order_id = $request->get('order_id', null);
        $order = $this->orders->find($order_id);
        if ($order->status === OrderConstants::STATUS_PENDING_SHIPMENT) {
            $response = $this->sendRequest(PlaceToPay::REVERSE_REQUEST, $order);

            return $this->responseHandler($response, $order);
        }

        $this->orders->cancel($request);

        return redirect()->to(route('user.order.show', [auth()->id(), $order_id]))
        ->with('message', trans('payment.messages.canceled'));
    }
}
