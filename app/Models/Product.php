<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name', 'stock', 'description', 'price', 'id_category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
