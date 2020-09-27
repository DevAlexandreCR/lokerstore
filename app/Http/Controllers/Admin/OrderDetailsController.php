<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param OrderDetail $detail
     * @return RedirectResponse
     */
    public function update(Request $request, OrderDetail $detail): RedirectResponse
    {
        $detail->update($request->all());

        return redirect()
            ->route('orders.show', $detail->order_id)
            ->with('success', __('Detail updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OrderDetail $detail
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(OrderDetail $detail): RedirectResponse
    {
        $detail->delete();

        return redirect()
            ->route('orders.show', $detail->order_id)
            ->with('success', __('Detail removed successfully'));
    }
}
