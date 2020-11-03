<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class UpdateStockProductAction
{
    public function execute(Product $product, int $quantity): void
    {
        if ($quantity < 1) {
            $quantity = 0;
        }
        $product->stock = $quantity;
        $product->save();
        Cache::tags(['products', 'api.products'])->flush();
    }
}
