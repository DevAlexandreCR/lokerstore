<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Stocks\StoreRequest;
use App\Http\Requests\Admin\Stocks\UpdateRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\Stock;
use App\Models\TypeSize;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StockController extends Controller
{
    protected $stock;
    public function __construct(Stock $stock)
    {
        $this->authorizeResource(Stock::class, 'stock');
        $this->stock = $stock;
    }


    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request) : RedirectResponse
    {
        $this->stock->create($request->all());

        return back()->with('success', __('Your product has been update successfully'));
    }

    /**
     * Return view for create a new stock
     *
     * @param Product $product
     * @return View
     */
    public function create(Product $product) : View
    {
        $colors = Color::all(['id', 'name']);
        $type_sizes = TypeSize::all(['id', 'name']);

        return view('admin.stocks.index', [
            'product' => $product,
            'colors' => $colors,
            'type_sizes' => $type_sizes
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

        return back()->with('success', __('Your product has been update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     * @param Stock $stock
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Stock $stock): RedirectResponse
    {
        $stock->delete();

        return back()->with('success', __('Your product has been update successfully'));
    }
}
