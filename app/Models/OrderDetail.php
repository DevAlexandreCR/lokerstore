<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = ['order_id', 'stock_id', 'quantity', 'unit_price', 'total_price'];

    /**
     * @return BelongsTo
     */
    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
