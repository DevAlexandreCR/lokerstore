<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'id_parent'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'id_parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'id_parent')->select(['id', 'name', 'id_parent']);
    }

    public static function primaries()
    {
        return self::all('id', 'name', 'id_parent')
            ->where('id_parent', '==', null)
            ->load(['children', 'children.products']);
    }

    public static function subCategories()
    {
        return self::all(['id', 'name', 'id_parent'])->where('id_parent', '!=', null);
    }

    public function getFullCategory(): string
    {
        return $this->parent()->qualifyColumn('name') . ' - ' . $this->name;
    }
}
