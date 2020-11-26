<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payer;
use App\Decorators\OrderDecorator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\IndexRequest;
use App\Http\Requests\Admin\Orders\StoreRequest;
use App\Http\Requests\Admin\Orders\UpdateRequest;
use App\Models\Order;
use App\Repositories\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdersController extends Controller
{
    private OrderDecorator $orders;

    public function __construct(OrderDecorator $orders)
    {
        $this->authorizeResource(Order::class, 'order');
        $this->orders = $orders;
    }

    /**
     * Display a listing of the orders.
     *
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        return view('admin.orders.index', [
            'orders' => $this->orders->index($request),
            'email'  => $request->get('email'),
            'from'   => $request->get('from'),
            'until'  => $request->get('until'),
            'status' => $request->get('status'),
        ]);
    }

    public function create(Products $products): View
    {
        return view('admin.orders.create', [
            'products' => $products->getForOrders(),
        ]);
    }

    public function store(StoreRequest $request, OrderDecorator $orders): RedirectResponse
    {
        $order = $orders->store($request);

        return redirect(route('orders.show', [
            'order' => $order
        ]))->with('success', trans('messages.crud', [
            'resource' => trans_choice('orders.orders', 1, ['orders_count' => '']),
            'status' => trans('fields.created')
        ]));
    }

    /**
     * Display the specified order.
     *
     * @param Order $order
     * @return View
     */
    public function show(Order $order): View
    {
        return view('admin.orders.show', [
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
            'payers' => Payer::all()
        ]);
    }

    /**
     * Update the specified order in storage.
     *
     * @param UpdateRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Order $order): RedirectResponse
    {
        $this->orders->update($request, $order);

        return redirect()->route('orders.show', $order->id)->with('success', trans('messages.crud', [
            'resource' => trans_choice('orders.orders', 1, ['orders_count' => '']),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Remove the specified order from storage.
     *
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->orders->destroy($order);

        return redirect()->route('orders.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('orders.orders', 1, ['orders_count' => '']),
            'status' => trans('fields.deleted')
        ]));
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     * @throws \JsonException
     */
    public function verify(Order $order): RedirectResponse
    {
        return $this->orders->verify($order);
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     * @throws \JsonException
     */
    public function reverse(Order $order): RedirectResponse
    {
        return $this->orders->reverse($order);
    }
}
