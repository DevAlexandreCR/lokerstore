<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'reference', 'name', 'description', 'cost', 'price', 'stock', 'id_category', 'is_active',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category')
            ->with('parent')->select(['id', 'name', 'id_parent']);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class)->select(['id', 'product_id', 'color_id', 'size_id', 'quantity']);
    }

    /**
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)->select(['id', 'name', 'product_id']);
    }

    /**
     * @return BelongsToMany
     */
    public function sizes(): BelongsToMany
    {
        return $this
                    ->belongsToMany(Size::class, 'stocks')
                    ->with(['colors' => function ($query) {
                        $query->wherePivot('product_id', $this->id);
                    }]);
    }

    /**
     * @param $query
     * @param $category
     * @return mixed|null
     */
    public function scopeByCategory($query, $category)
    {
        if (empty($category)) {
            return null;
        }

        $id = $this->getIdCategory($category);

        return $query->whereHas('category', function (Builder $query) use ($category, $id) {
            $query
                ->where('name', $category)
                ->orWhere('id_parent', $id);
        });
    }

    /**
     * @param $query
     * @param $price
     * @return mixed|null
     */
    public function scopePrice($query, $price)
    {
        if (!$price) {
            return null;
        }

        $price = $this->splitPrice($price);

        return $query
                    ->where('price', '>', $price[0])
                    ->where('price', '<', $price[1]);
    }

    /**
     * @param string $price
     * @return array
     */
    public function splitPrice(string $price): array
    {
        return explode('-', $price);
    }

    /**
     * @param $query
     * @param $colors
     * @return mixed|null
     */
    public function scopeColors($query, $colors)
    {
        if (empty($colors)) {
            return null;
        }

        return $query->whereHas('stocks', function ($query) use ($colors) {
            $query->whereIn('color_id', $colors);
        });
    }

    /**
     * @param $query
     * @param $sizes
     * @return mixed|null
     */
    public function scopeSizes($query, $sizes)
    {
        if (empty($sizes)) {
            return null;
        }

        return $query->whereHas('stocks', function ($query) use ($sizes) {
            $query->whereIn('size_id', $sizes);
        });
    }

    /**
     * @param $query
     * @param $product_id
     * @return mixed|null
     */
    public function scopeSizesByProduct($query, $product_id)
    {
        return $query->whereHas('stocks', function ($query) use ($product_id) {
            $query
                ->where('product_id', $product_id);
        });
    }

    /**
     * @param $query
     * @return mixed|null
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * @param $query
     * @param $tags
     * @return mixed|null
     */
    public function scopeWithTags($query, $tags)
    {
        if (empty($tags)) {
            return null;
        }

        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('name', $tags);
        });
    }

    /**
     * @param $query
     * @param $search
     * @return mixed|null
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return null;
        }

        return $query
            ->where('reference', 'like', '%' . $search . '%')
            ->orwhere('name', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%');
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        if ($this->is_active) {
            return trans('actions.enabled');
        }

        return trans('actions.disabled');
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return number_format($this->price, 2, ',', '.') . 'COP';
    }

    /**
     * @return false|string
     */
    public function getDescription()
    {
        return substr($this->description, 0, 30);
    }

    public static function boot(): void
    {
        parent::boot();

        static::deleting(function ($product) {
            $photos = $product->photos();

            foreach ($photos as $photo) {
                $name = $photo->name;
                $photo->delete();
                Storage::disk('public_photos')->delete($name);
            }
        });
    }

    /**
     * Search category and return 0 if not exist
     *
     * @param string $category
     * @return integer
     */
    private function getIdCategory(string $category): int
    {
        return Category::where('name', $category)->firstOrFail()->id;
    }
}
