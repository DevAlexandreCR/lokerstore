<?php

namespace App\Decorators;

use App\Constants\Payments as Pay;
use App\Constants\PlaceToPay;
use App\Http\Requests\Admin\Orders\indexRequest;
use App\Models\Order;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Repositories\Payments;
use App\Traits\HttpClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderDecorator
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

    public function index(IndexRequest $request)
    {
        return $this->orders->query($request);
    }

    public function update(Request $request, Model $model): void
    {
        $this->orders->update($request, $model);
    }

    public function destroy(Model $model): void
    {
        $this->orders->destroy($model);
    }

    public function verify(Order $order): RedirectResponse
    {
        $response = $this->sendRequest(PlaceToPay::GET_REQUEST_INFORMATION, $order);

        return $this->responseHandler($response, $order);
    }

    public function reverse(Order $order): RedirectResponse
    {
        $response = $this->sendRequest(PlaceToPay::REVERSE_REQUEST, $order);

        return $this->responseHandler($response, $order);
    }

    public function responseHandler($response, Order $order): RedirectResponse
    {
        $status = $response->status->status;
        switch ($status) {
            case PlaceToPay::PENDING:
                $message = __('Payment pending');
                break;
            case PlaceToPay::APPROVED:
                if ($response->status->message === PlaceToPay::MESSAGE_REVERSED) {
                    $this->payments->setStatus($order->payment, Pay::STATUS_CANCELED);
                    $message = __('Payment been reversed success');
                } else {
                    $this->payments->setStatus($order->payment, $status);
                    $this->payments->setDataPayment($order->payment, $response);
                    $message = __('Payment has been success');
                }
                break;
            case PlaceToPay::REJECTED:
                $this->payments->setStatus($order->payment, $status);
                $message = __('Payment has been rejected');
                break;
            default:
                $message = $response->status->message;
        }

        return redirect()->to(route('orders.show', $order->id))
            ->with('success', $message);
    }
}
