<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
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
        $redirect = $this->orders->store($request);

        return new RedirectResponse($redirect);
    }

    public function index(User $user): View
    {
        return view('web.users.orders.index', [
            'orders' => $user->orders
        ]);
    }

    public function statusPayment(UpdateRequest $request): RedirectResponse
    {
        return $this->orders->getRequestInformation($request);
    }

    public function show(int $user_id, int $order_id): View
    {
        $order = $this->orders->find($user_id, $order_id);

        return view('web.users.orders.show', ['order' => $order]);
    }
}
