<?php

namespace App\Interfaces\Api;

use App\Http\Requests\Api\Stocks\UpdateRequest;
use App\Models\Stock;

interface ApiStocksInterface
{
    /**
     * @param UpdateRequest $request
     * @param Stock $stock
     * @return mixed
     */
    public function update(UpdateRequest $request, Stock $stock);
}
