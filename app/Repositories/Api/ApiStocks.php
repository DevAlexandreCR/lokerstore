<?php


namespace App\Repositories\Api;

use App\Models\Stock;
use App\Interfaces\Api\ApiStocksInterface;
use App\Http\Requests\Api\Stocks\UpdateRequest;

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
