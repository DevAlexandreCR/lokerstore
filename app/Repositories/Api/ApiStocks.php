<?php

namespace App\Repositories\Api;

use App\Http\Requests\Api\Stocks\UpdateRequest;
use App\Interfaces\Api\ApiStocksInterface;
use App\Models\Stock;

class ApiStocks implements ApiStocksInterface
{

    /**
     * @param UpdateRequest $request
     * @param Stock $model
     * @return mixed
     */
    public function update(UpdateRequest $request, Stock $model)
    {
        return $model->update($request->all());
    }
}
