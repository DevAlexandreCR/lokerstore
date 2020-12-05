<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    protected $fillable = ['product_id', 'color_id', 'size_id', 'quantity'];

    public function size()
    {
        return $this->belongsTo(Size::class)->select(['id', 'name', 'type_sizes_id']);
    }

    public function color()
    {
        return $this->belongsTo(Color::class)->select(['id', 'name']);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_stock');
    }

    public function scopeFindStock($query, $product_id, $color_id, $size_id)
    {
        return $query
            ->where('product_id', $product_id)
            ->where('color_id', $color_id)
            ->where('size_id', $size_id);
    }
}
