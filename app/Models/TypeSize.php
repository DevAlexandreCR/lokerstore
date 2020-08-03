<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeSize extends Model
{
    protected $table = 'type_sizes';
    
    public function sizes()
    {
        return $this->hasMany(Size::class, 'type_sizes_id');
    }
}
