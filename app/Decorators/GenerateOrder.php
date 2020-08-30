<?php

namespace App\Decorators;

use App\Constants\PlaceToPay;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderDetails;
use App\Repositories\Orders;
use App\Repositories\Payments;
use App\Traits\GuzzleClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use function GuzzleHttp\Promise\promise_for;

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

        $response = $this->sendRequest($order);

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
        $requestId = $response->requestId;
        $processUrl = $response->processUrl;

        if ($status === PlaceToPay::OK) {
            $this->payments->create($order_id, $requestId, $processUrl);
            return Redirect::away($processUrl)->send();
        } else {
            redirect()->back()->with('error', $response->status->message);
        }


    }
}
