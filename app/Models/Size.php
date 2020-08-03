<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    protected $fillable = ['name'];

    protected $table = 'sizes';

    public function stocks() : HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function type() : BelongsTo
    {
        return $this->belongsTo(TypeSize::class, 'type_sizes_id');
    }
}
