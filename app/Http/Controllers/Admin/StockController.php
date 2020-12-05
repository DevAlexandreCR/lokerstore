<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stocks\StoreRequest;
use App\Http\Requests\Admin\Stocks\UpdateRequest;
use App\Interfaces\ColorsInterface;
use App\Interfaces\TypeSizesInterface;
use App\Models\Product;
use App\Models\Stock;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StockController extends Controller
{
    protected Stock $stock;

    public function __construct(Stock $stock)
    {
        $this->authorizeResource(Stock::class, 'stock');
        $this->stock = $stock;
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->stock->create($request->all());

        return back()->with('success', trans('messages.crud', [
            'resource' => trans_choice('products.product', 1, ['product_count' => '']),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Return view for create a new stock
     *
     * @param Product $product
     * @param ColorsInterface $colors
     * @param TypeSizesInterface $sizes
     * @return View
     */
    public function create(Product $product, ColorsInterface $colors, TypeSizesInterface $sizes): View
    {
        return view('admin.stocks.index', [
            'product' => $product->load('stocks', 'stocks.color', 'stocks.size', 'stocks.size.type'),
            'colors' => $colors->index(),
            'type_sizes' => $sizes->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Stock $stock
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Stock $stock): RedirectResponse
    {
        $stock->update($request->all());

        return back()->with('success', trans('messages.crud', [
            'resource' => trans_choice('products.product', 1, ['product_count' => '']),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     * @param Stock $stock
     * @throws Exception
     * @return RedirectResponse
     */
    public function destroy(Stock $stock): RedirectResponse
    {
        $stock->delete();

        return back()->with('success', trans('messages.crud', [
            'resource' => trans_choice('products.product', 1, ['product_count' => '']),
            'status' => trans('fields.deleted')
        ]));
    }
}
