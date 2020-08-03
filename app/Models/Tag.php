<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    protected $table = 'tags';

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeSearch($query, $search)
    {
        if (! $search) return;
        
        return $query->where('name', $search);
    }

}
