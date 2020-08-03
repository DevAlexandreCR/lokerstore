<?php

namespace App\Listeners;

use App\Actions\Products\UpdateStockProductAction;
use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetStockProduct
{
    public $updateStockProductAction;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UpdateStockProductAction $updateStockProductAction)
    {
        $this->updateStockProductAction = $updateStockProductAction;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OnStockCreatedOrUpdatedEvent $event)
    {
        $stock = $event->stock;

        $product = Product::find($stock->product->id);

        $stocks = $product->stocks;
        $quantity = 0;
        foreach ($stocks as $stk) {
            $quantity += $stk->quantity;
        }
        
        $this->updateStockProductAction->execute($product, $quantity);
    }
}
