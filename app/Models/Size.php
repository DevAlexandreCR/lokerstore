<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Size extends Model
{
    protected $fillable = ['name'];

    protected $table = 'sizes';

    /**
     * @return BelongsToMany
     */
    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this
            ->belongsToMany(Color::class, 'stocks')
            ->withPivot('quantity');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(TypeSize::class, 'type_sizes_id');
    }
}
