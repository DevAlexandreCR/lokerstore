<?php

namespace App\Actions\Products;

use App\Models\Stock;

class UpdateStockProductAction
{
    public function execute(array $data)
    {
        $stock = new Stock();
        $stock->product_id  = $data['product_id'];
        $stock->size_id     = $data['size_id'];
        $stock->color_id    = $data['color_id'];

        $stock->save();
    }
}