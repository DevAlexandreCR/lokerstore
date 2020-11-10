<?php

namespace App\Http\Controllers\Admin;

use App\Decorators\OrderDecorator;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\indexRequest;
use App\Http\Requests\Admin\Orders\UpdateRequest;
use App\Models\Order;
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
     * @param indexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        return view('admin.orders.index', [
            'orders' => $this->orders->index($request),
            'email' => $request->get('email'),
            'date' => $request->get('date'),
            'status' => $request->get('status')
        ]);
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
            )
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

        return redirect()
            ->route('orders.show', $order->id)
            ->with('success', __('Order updated successfully'));
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

        return redirect()
            ->route('orders.index')
            ->with('success', __('Order removed successfully'));
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function verify(Order $order): RedirectResponse
    {
        return $this->orders->verify($order);
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function reverse(Order $order): RedirectResponse
    {
        return $this->orders->reverse($order);
    }
}
