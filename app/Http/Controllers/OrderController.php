<?php

namespace App\Http\Controllers;

use App\Constants\Orders;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected $orders;

    public function __construct(OrderInterface $orders)
    {
        $this->orders = $orders;
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        return $this->orders->store($request);
    }

    /**
     * Resend request for payment
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function resend(UpdateRequest $request): RedirectResponse
    {
        return $this->orders->resend($request);
    }

    public function index(User $user): View
    {
        return view('web.users.orders.index', [
            'orders' => $user->orders
        ]);
    }

    /**
     * Query status payment to p2p
     * @param UpdateRequest $request
     * @return RedirectResponse
     */
    public function statusPayment(UpdateRequest $request): RedirectResponse
    {
        $order_id = $request->get('order_id', null);

        return $this->orders->getRequestInformation($order_id);
    }

    public function show(int $user_id, int $order_id): View
    {
        header("Cache-Control: no-cache, must-revalidate");
        $order = $this->orders->find($order_id);
        if ($order->status === Orders::STATUS_PENDING_PAY) $this->orders->getRequestInformation($order_id);
        $order = $this->orders->find($order_id);
        return view('web.users.orders.show', ['order' => $order]);
    }

    /**
     * reverse payment from p2p
     * @param UpdateRequest $request
     * @return mixed
     */
    public function reverse(UpdateRequest $request)
    {
        return $this->orders->reverse($request);
    }
}
