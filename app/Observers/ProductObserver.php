<?php

namespace App\Observers;

use App\Events\OnProductUpdateEvent;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the product "updated" event.
     * @param Product $product
     */
    public function updated(Product $product)
    {
        event(new OnProductUpdateEvent($product));
    }
}
