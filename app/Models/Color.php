<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name', 'code'];

    protected $table = 'colors';

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
