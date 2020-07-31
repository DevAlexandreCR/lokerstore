<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = ['name'];

    protected $table = 'sizes';

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
