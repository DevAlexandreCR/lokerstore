<?php

namespace App\Decorators;

use App\Constants\PlaceToPay;
use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Repositories\Payments;
use App\Constants\Payments as Pay;
use App\Traits\GuzzleClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GenerateOrder implements OrderInterface
{
    use GuzzleClient;

    protected $orders;
    protected $orderDetails;
    protected $payments;

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

        $this->orderDetails->create($order->id);

        $order->orderDetails->each(function ($detail) use($order){
            $order->amount += $detail->total_price;
        });

        $order->save();

        $response = $this->sendRequest(PlaceToPay::CREATE_REQUEST, $order);

        return $this->responseHandler($response, $order->id);
    }

    public function update(Request $request, Model $model)
    {
        // TODO: Implement update() method.
    }

    public function destroy(Model $model)
    {
        // TODO: Implement destroy() method.
    }

    public function responseHandler($response, int $order_id): RedirectResponse
    {
        $status = $response->status->status;
        $order = $this->find($order_id);
        switch ($status)
        {
            case PlaceToPay::OK:
                $requestId = $response->requestId;
                $processUrl = $response->processUrl;
                $this->payments->create($order_id, $requestId, $processUrl);
                return redirect()->away($processUrl)->send();
            case PlaceToPay::PENDING;
                $message = __('Your payment is not processed yet, this may take a few minutes');
                break;
            case PlaceToPay::APPROVED:
                if ($response->status->message === PlaceToPay::MESSAGE_REVERSED)
                {
                    $this->payments->setStatus($order->payment, Pay::STATUS_CANCELED);
                    $message = __('Your payment has been reversed');
                }
                else
                {
                    $this->payments->setStatus($order->payment, $status);
                    $this->payments->setDataPayment($order->payment, $response);
                    $message = __('Your payment has been success');
                }
                break;
            case PlaceToPay::REJECTED:
                $this->payments->setStatus($order->payment, $status);
                $message = __('Your payment has been failed');
                break;
            default:
                $message = $response->status->message;
        }
        return redirect()->to( route('user.order.show', [auth()->id(), $order_id]))
            ->with('message', $message);
    }

    public function find(int $order_id)
    {
        return $this->orders->find($order_id);
    }

    public function getRequestInformation(int $order_id)
    {
        $order = $this->orders->find($order_id);
        $response = $this->sendRequest( PlaceToPay::GET_REQUEST_INFORMATION, $order);

        return $this->responseHandler($response, $order_id);
    }

    public function resend(UpdateRequest $request)
    {
        $order_id = $request->get('order_id', null);
        $order = $this->orders->find($order_id);

        $response = $this->sendRequest( PlaceToPay::CREATE_REQUEST, $order);

        return $this->responseHandler($response, $order_id);
    }

    public function reverse(UpdateRequest $request)
    {
        $order_id = $request->get('order_id', null);
        $order = $this->orders->find($order_id);
        $response = $this->sendRequest(PlaceToPay::REVERSE_REQUEST, $order);
        return $this->responseHandler($response, $order->id);
    }
}
