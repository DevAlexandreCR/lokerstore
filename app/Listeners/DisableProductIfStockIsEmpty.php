<?php

namespace App\Listeners;

use App\Actions\Products\EnableOrDisableProductAction;
use App\Events\OnProductUpdateEvent;

class DisableProductIfStockIsEmpty
{
    public EnableOrDisableProductAction $enableOrDisableProductAction;

    /**
     * DisableProductIfStockIsEmpty constructor.
     * @param EnableOrDisableProductAction $enableOrDisableProductAction
     */
    public function __construct(EnableOrDisableProductAction $enableOrDisableProductAction)
    {
        $this->enableOrDisableProductAction = $enableOrDisableProductAction;
    }

    /**
     * @param OnProductUpdateEvent $event
     */
    public function handle(OnProductUpdateEvent $event): void
    {
        $product = $event->product;

        if ($product->stock === 0 && $product->is_active) {
            $this->enableOrDisableProductAction->execute($product, false);
        }
    }
}
