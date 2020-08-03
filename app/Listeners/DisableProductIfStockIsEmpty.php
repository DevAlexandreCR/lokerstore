<?php

namespace App\Listeners;

use App\Actions\Products\EnableOrDisableProductAction;
use App\Events\OnProductUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DisableProductIfStockIsEmpty
{
    public $enableOrDisableProductAction;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(EnableOrDisableProductAction $enableOrDisableProductAction)
    {
        $this->enableOrDisableProductAction = $enableOrDisableProductAction;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OnProductUpdateEvent $event)
    {
        $product = $event->product;

        if ($product->stock == 0 && $product->is_active)
        {
            $this->enableOrDisableProductAction->execute($product, false);
        }
    }
}
