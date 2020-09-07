<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    protected $fillable = ['order_id', 'request_id', 'process_url', 'status', 'reference', 'method', 'last_digit'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function payer(): HasOne
    {
        return $this->hasOne(Payer::class);
    }
}
