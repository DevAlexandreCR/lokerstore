<?php

namespace App\Models;

use App\Constants\Metrics;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'id_parent'];

    public function metrics(): MorphMany
    {
        return $this->morphMany(Metric::class, 'measurable', Metrics::CATEGORIES);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'id_parent')->select('id', 'name', 'id_parent');
    }

    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'id_parent')->select(['id', 'name', 'id_parent']);
    }

    /**
     * @return Category[]|Collection
     */
    public static function primaries()
    {
        return self::all('id', 'name', 'id_parent')
            ->where('id_parent', '==', null)
            ->load(['children', 'children.products']);
    }

    /**
     * @return Category[]|Collection
     */
    public static function subCategories()
    {
        return self::all(['id', 'name', 'id_parent'])->where('id_parent', '!=', null);
    }

    /**
     * @return string
     */
    public function getFullCategory(): string
    {
        return $this->parent->name . ' - ' . $this->name;
    }
}
