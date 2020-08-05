<?php

namespace App\Observers;

use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Models\Stock;

class StockObserver
{
    /**
     * Handle the stock "created" event.
     * @param Stock $stock
     */
    public function created(Stock $stock): void
    {
        event(new OnStockCreatedOrUpdatedEvent($stock));
    }

    /**
     * Handle the stock "updated" event.
     * @param Stock $stock
     */
    public function updated(Stock $stock): void
    {
        event(new OnStockCreatedOrUpdatedEvent($stock));
    }

    /**
     * Handle the stock "deleted" event.
     * @param Stock $stock
     */
    public function deleted(Stock $stock): void
    {
        event(new OnStockCreatedOrUpdatedEvent($stock));
    }
}
