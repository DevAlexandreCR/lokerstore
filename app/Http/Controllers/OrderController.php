<?php

namespace App\Http\Controllers;

use App\Http\Requests\Orders\StoreRequest;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orders;

    public function __construct(OrderInterface $orders)
    {
        $this->orders = $orders;
    }

    public function store(StoreRequest $request)
    {
        $redirect = $this->orders->store($request);

        return new RedirectResponse($redirect);
    }

    public function update(Request $request, Order $order)
    {

    }
}
