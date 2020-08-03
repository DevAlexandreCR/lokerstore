<?php

namespace App\Actions\Products;

use App\Models\Product;

class EnableOrDisableProductAction
{
    public function execute(Product $product, bool $enable)
    {
        $product->is_active = $enable;

        $product->save();
    }
}