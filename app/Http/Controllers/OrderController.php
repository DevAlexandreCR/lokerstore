<?php

namespace App\Http\Controllers;

use App\Constants\Orders;
use App\Http\Requests\Web\Orders\StoreRequest;
use App\Http\Requests\Web\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected OrderInterface $orders;

    public function __construct(OrderInterface $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param StoreRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function store(StoreRequest $request, User $user): RedirectResponse
    {
        return $this->orders->store($request);
    }

    /**
     * Resend request for payment
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function resend(UpdateRequest $request, User $user): RedirectResponse
    {
        return $this->orders->resend($request);
    }

    public function index(User $user): View
    {
        return view('web.users.orders.index', [
            'orders' => $user->orders,
        ]);
    }

    /**
     * Query status payment to p2p
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function statusPayment(UpdateRequest $request, User $user): RedirectResponse
    {
        return $this->orders->getRequestInformation($request->get('order_id', null));
    }

    public function show(User $user, Order $order): View
    {
        if ($order->status === Orders::STATUS_PENDING_PAY && $order->payment) {
            $this->orders->getRequestInformation($order->id);
        }

        return view(
            'web.users.orders.show',
            [
                'order' => $order->load(
                    'orderDetails',
                    'payment',
                    'payment.payer',
                    'orderDetails.stock',
                    'orderDetails.stock.product',
                    'orderDetails.stock.product.photos',
                    'orderDetails.stock.color',
                    'orderDetails.stock.size'
                ),
            ]
        );
    }

    /**
     * reverse payment from p2p
     * @param UpdateRequest $request
     * @param User $user
     * @return mixed
     */
    public function reverse(UpdateRequest $request, User $user)
    {
        return $this->orders->reverse($request);
    }
}
