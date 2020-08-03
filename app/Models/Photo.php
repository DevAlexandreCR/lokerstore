<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = ['name', 'file_path'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
