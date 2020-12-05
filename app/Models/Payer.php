<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payer extends Model
{
    protected $fillable = ['document', 'document_type', 'name', 'email', 'last_name', 'phone'];

    /**
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->name . ' ' . $this->last_name;
    }
}
