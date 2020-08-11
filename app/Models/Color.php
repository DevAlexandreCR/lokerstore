<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['name', 'code'];

    protected $table = 'colors';

    public function stocks()
    {
        return $this->belongsToMany(Stock::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'stocks');
    }
}
