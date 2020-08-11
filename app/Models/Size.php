<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Size extends Model
{
    protected $fillable = ['name'];

    protected $table = 'sizes';

    public function stocks() : BelongsToMany
    {
        return $this->belongsToMany(Stock::class);
    }

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }


    public function colors(): BelongsToMany
    {
        return $this
            ->belongsToMany(Color::class, 'stocks')
            ->withPivot('quantity');
    }


    public function type() : BelongsTo
    {
        return $this->belongsTo(TypeSize::class, 'type_sizes_id');
    }
}
