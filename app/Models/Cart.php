<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function stocks(): BelongsToMany
    {
        return $this
            ->belongsToMany(Stock::class, 'cart_stock')
            ->withPivot('quantity');
    }

    public function countProducts(): int
    {
        return $this->stocks()->get()->count();
    }

    public function cartPrice()
    {
        $price = 0;
        $stocks = $this->stocks()->get(['product_id']);
        foreach ($stocks as $stock) {
            $price += $stock->product->price*$stock->pivot->quantity;
        }

        return round($price, 0,  PHP_ROUND_HALF_UP) . 'COP';
    }

    public function emptyCart(): void
    {
        $this->stocks()->detach(null);
    }

    public function getSubTotalFromProduct(Stock $stock)
    {
        $price = $stock->product->price * $stock->pivot->quantity;
        return round($price, 0,  PHP_ROUND_HALF_UP) . 'COP';
    }
}
