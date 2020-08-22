<?php

namespace App\Actions\Products;

use App\Models\Product;

class UpdateStockProductAction
{
    public function execute(Product $product, int $quantity): void
    {
        $product->stock = $quantity;

        $product->save();
    }
}
