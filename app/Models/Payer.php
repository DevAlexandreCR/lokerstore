<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payer extends Model
{
    protected $fillable = ['payment_id', 'document', 'document_type', 'name', 'email', 'last_name', 'phone'];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->last_name;
    }
}
