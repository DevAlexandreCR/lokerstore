<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrdersController extends Controller
{
    private $orders;

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Display a listing of the orders.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => $this->orders::all()
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
            'order' => $order
        ]);
    }

    /**
     * Update the specified order in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->all());

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
        $this->orders::destroy($order->id);

        return redirect()
            ->route('orders.index')
            ->with('success', __('Order removed successfully'));
    }
}
