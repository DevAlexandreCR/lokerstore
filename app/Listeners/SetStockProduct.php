<?php

namespace App\Listeners;

use App\Actions\Products\UpdateStockProductAction;
use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Models\Product;

class SetStockProduct
{
    public UpdateStockProductAction $updateStockProductAction;

    /**
     * Create the event listener.
     *
     * @param UpdateStockProductAction $updateStockProductAction
     */
    public function __construct(UpdateStockProductAction $updateStockProductAction)
    {
        $this->updateStockProductAction = $updateStockProductAction;
    }

    /**
     * Handle the event.
     *
     * @param OnStockCreatedOrUpdatedEvent $event
     * @return void
     */
    public function handle(OnStockCreatedOrUpdatedEvent $event): void
    {
        $stock = $event->stock;

        $product = Product::find($stock->product_id);

        $stocks = $product->stocks;
        $quantity = 0;
        foreach ($stocks as $stk) {
            $quantity += $stk->quantity;
        }

        $this->updateStockProductAction->execute($product, $quantity);
    }
}
