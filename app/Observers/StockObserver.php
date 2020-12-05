<?php

namespace App\Observers;

use App\Events\OnStockCreatedOrUpdatedEvent;
use App\Models\Stock;
use Exception;

class StockObserver
{
    public function creating(Stock $stock): bool
    {
        $stockExist = Stock::where('product_id', $stock->product_id)
                ->where('color_id', $stock->color_id)
                ->where('size_id', $stock->size_id)->first();

        if ($stockExist !== null) {
            $stockExist->quantity += $stock->quantity;
            $stockExist->save();

            return false;
        }

        return true;
    }
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
     * @throws Exception
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
