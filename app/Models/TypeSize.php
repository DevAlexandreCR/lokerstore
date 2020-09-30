<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeSize extends Model
{
    protected $table = 'type_sizes';

    public function sizes(): HasMany
    {
        return $this
                ->hasMany(Size::class, 'type_sizes_id')
                ->select(['id', 'name', 'type_sizes_id']);
    }
}
