<?php

namespace App\Http\Controllers;

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

    public function statusPayment(UpdateRequest $request): RedirectResponse
    {
        $order_id = $request->get('order_id', null);

        return $this->orders->getRequestInformation($order_id);
    }

    public function show(int $user_id, int $order_id): View
    {
        header("Cache-Control: no-cache, must-revalidate");
        $this->orders->getRequestInformation($order_id);
        $order = $this->orders->find($order_id);
        return view('web.users.orders.show', ['order' => $order]);
    }
}
