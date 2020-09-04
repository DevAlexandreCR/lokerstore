<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ['order_id', 'request_id', 'process_url', 'status', 'pay_reference'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
