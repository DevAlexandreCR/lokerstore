<?php

namespace App\Actions\Stocks;

use App\Models\Stock;

class CreateOrUpdateStockAction
{
    public function execute(array $data): void
    {
        $stock = new Stock();
        $stock->product_id  = $data['product_id'];
        $stock->size_id     = $data['size_id'];
        $stock->color_id    = $data['color_id'];

        $stock->save();
    }
}
