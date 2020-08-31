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
        logger()->channel('prueba')->alert('product updated');
        event(new OnProductUpdateEvent($product));
    }
}
