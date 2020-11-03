<?php


namespace App\Interfaces\Api;

use App\Models\Stock;
use App\Http\Requests\Api\Stocks\UpdateRequest;

interface ApiStocksInterface
{
    /**
     * @param UpdateRequest $request
     * @param Stock $stock
     * @return mixed
     */
    public function update(UpdateRequest $request, Stock $stock);
}
