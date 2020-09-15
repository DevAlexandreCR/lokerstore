<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $fillable = ['order_id', 'stock_id', 'quantity', 'unit_price', 'total_price'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
