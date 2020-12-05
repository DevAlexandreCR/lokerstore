<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Color extends Model
{
    protected $fillable = ['name', 'code'];

    protected $table = 'colors';

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class);
    }

    public function sizes(): BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'stocks');
    }
}
