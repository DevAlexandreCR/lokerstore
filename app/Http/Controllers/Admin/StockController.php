<?php

namespace App\Http\Controllers\Admin;

use App\Events\OnProductUpdateEvent;
use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;

        return response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock = $this->stock->create($request->all());

        return response();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        $stock->update($request->all());

        return response();
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
    }
}
