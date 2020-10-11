<?php


namespace App\Decorators\Api;


use App\Models\Size;
use App\Models\Color;
use App\Models\Stock;
use App\Models\TypeSize;
use App\Repositories\Api\ApiStocks;
use App\Interfaces\Api\ApiStocksInterface;
use App\Http\Requests\Api\Stocks\UpdateRequest;

class StocksDecorator implements ApiStocksInterface
{
    private ApiStocks $stocks;

    public function __construct(ApiStocks $stocks)
    {
        $this->stocks = $stocks;
    }

    /**
     * @param UpdateRequest $request
     * @param Stock $stock
     * @return mixed
     */
    public function update(UpdateRequest $request, Stock $stock)
    {
        $color_id = Color::where('name', $request->get('color'))->first()->id;
        $type_id = TypeSize::where('name', $request->get('type_size'))->first()->id;
        $size_id = Size::where('name', $request->get('size'))->where('type_sizes_id', $type_id)->first()->id;
        $quantity = $request->get('quantity');

        $request->merge([
            'color_id' => $color_id,
            'size_id' => $size_id,
            'quantity' => $quantity
        ]);

        return $this->stocks->update($request, $stock);
    }
}
