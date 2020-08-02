<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Stocks\StoreOrUpdateRequest;
use App\Http\Requests\Stocks\StoreRequest;
use App\Http\Requests\Stocks\UpdateRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\Stock;
use App\Models\TypeSize;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockController extends Controller
{
    protected $stock;
    
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }


    /**
     * Store a new Stock
     *
     * @param Request $request
     * @return void
     */
    public function store(StoreRequest $request)
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Stock $stock)
    {
        $stock->update($request->all());

        return back()->with('success', __('Your product has been update successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        $stock->delete();

        return back()->with('success', __('Your product has been update successfully'));
    }
}
