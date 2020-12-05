<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function stocks(): BelongsToMany
    {
        return $this
            ->belongsToMany(Stock::class, 'cart_stock')
            ->withPivot('quantity');
    }

    public function countProducts(): int
    {
        return $this->stocks()->count();
    }

    public function scopeCart($query, int $id)
    {
        return $query
            ->where('user_id', $id);
    }

    public function cartPrice(): string
    {
        $price = 0;
        $stocks = $this->stocks()->get(['product_id']);
        foreach ($stocks as $stock) {
            $price += $stock->product->price * $stock->pivot->quantity;
        }

        return number_format($price, 2, ',', '.') . 'COP';
    }

    public function emptyCart(): void
    {
        $this->stocks()->detach(null);
    }

    public function getSubTotalFromProduct(Stock $stock): string
    {
        $price = $stock->product->price * $stock->pivot->quantity;

        return number_format($price, 2, ',', '.') . 'COP';
    }
}
