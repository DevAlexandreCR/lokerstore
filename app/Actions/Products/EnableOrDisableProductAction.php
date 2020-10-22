<?php

namespace App\Actions\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class EnableOrDisableProductAction
{
    public function execute(Product $product, bool $enable): void
    {
        $product->is_active = $enable;

        $product->save();

        Cache::tags(['products', 'api.products'])->flush();
    }
}
