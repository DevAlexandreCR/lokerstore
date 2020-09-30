<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    protected $table = 'tags';

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeSearch($query, $search)
    {
        if (! $search) {
            return null;
        }

        return $query
            ->where('name', $search);
    }

}
