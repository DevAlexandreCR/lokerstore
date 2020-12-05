<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Stocks\UpdateRequest;
use App\Interfaces\Api\ApiStocksInterface;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    private ApiStocksInterface $stocks;

    public function __construct(ApiStocksInterface $stocks)
    {
        $this->stocks = $stocks;
    }

    public function update(UpdateRequest $request, Stock $stock): JsonResponse
    {
        $this->stocks->update($request, $stock);

        return response()->json([
            'status' => [
                'status'  => 'OK',
                'message' => trans('messages.crud', [
                    'resource' => trans('products.stock'),
                    'status' => trans('fields.updated')
                ]),
                'code'    => 200,
            ],
            'stock' => $stock,
        ]);
    }
}
