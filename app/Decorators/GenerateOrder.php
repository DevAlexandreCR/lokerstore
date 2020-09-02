<?php

namespace App\Decorators;

use App\Constants\PlaceToPay;
use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Constants\Orders as OrderConstants;
use App\Repositories\Payments;
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

    public function responseHandler($response, int $order_id, UpdateRequest $request = null): RedirectResponse
    {
        $status = $response->status->status;

        switch ($status)
        {
            case PlaceToPay::OK:
                $requestId = $response->requestId;
                $processUrl = $response->processUrl;
                $this->payments->create($order_id, $requestId, $processUrl);
                return redirect()->away($processUrl)->send();
                break;
            case PlaceToPay::PENDING;
                return redirect()->to( route('user.order.show', [auth()->id(), $order_id]))
                    ->with('message', __('Your payment is not processed yet, this may take a few minutes'));
                break;
            case PlaceToPay::APPROVED:
                $request->merge([
                    'status' => $this->getStatus($status)
                ]);
                $order = $this->find($request->user()->id, $order_id);
                $this->payments->setStatus($order->payment, $status);
                $this->orders->getRequestInformation($request);
                return redirect()->to( route('user.order.show', [auth()->id(), $order_id]))
                    ->with('message', __('Your payment has been success'));
                break;
            case PlaceToPay::REJECTED:
                $request->merge([
                    'status' => $this->getStatus($status)
                ]);
                $order = $this->find($request->user()->id, $order_id);
                $this->payments->setStatus($order->payment, $status);
                $this->orders->getRequestInformation($request);
            default:
                return redirect()->to( route('user.order.show', [auth()->id(), $order_id]))->with('error', $response->status->message);
                break;

        }
    }

    public function find(int $user_id, int $order_id)
    {
        return $this->orders->find($user_id, $order_id);
    }

    public function getRequestInformation(UpdateRequest $request)
    {
        $order_id = $request->get('order_id', null);
        $order = $this->orders->find(auth()->id(), $order_id);

        $response = $this->sendRequest( PlaceToPay::GET_REQUEST_INFORMATION, $order);

        return $this->responseHandler($response, $order_id, $request);
    }

    public function getStatus(string $status): string
    {
        switch ($status)
        {
            case PlaceToPay::PENDING:
                return OrderConstants::STATUS_PENDING_PAY;
                break;
            case PlaceToPay::REJECTED:
                return OrderConstants::STATUS_REJECTED;
                break;
            case PlaceToPay::APPROVED:
                return OrderConstants::STATUS_PENDING_SHIPMENT;
                break;
            default :
                return OrderConstants::STATUS_PENDING_PAY;
        }
    }
}
