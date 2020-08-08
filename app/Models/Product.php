<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name', 'description', 'price', 'stock', 'id_category', 'is_active'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function scopeByCategory($query, $category)
    {
        if (empty($category)) return null;

        $id = $this->getIdCategory($category);

        return $query->whereHas('category', function($query) use ($category, $id) {
            $query
                ->where('name', $category)
                ->orWhere('id_parent', $id);
        });
    }

    public function scopePrice($query, $price)
    {
        if (!$price) return null;

        $price = $this->splitPrice($price);

        return $query
                    ->where('price', '>', $price[0])
                    ->where('price', '<', $price[1]);
    }

    public function splitPrice(string $price) : array
    {
        return explode('-', $price);
    }

    public function scopeColors($query, $colors)
    {
        if (empty($colors)) return null;

        return $query->whereHas('stocks', function ($query) use ($colors) {
                    $query->whereIn('color_id', $colors);
        });
    }

    public function scopeSizes($query, $sizes)
    {
        if (empty($sizes)) return null;

        return $query->whereHas('stocks', function ($query) use ($sizes) {
            $query->whereIn('size_id', $sizes);
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithTags($query, $tags)
    {
        if (empty($tags)) return null;

        return $query->whereHas('tags', function($query) use ($tags) {
            $query->whereIn('name', $tags);
        });
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) return null;

        return $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
    }

    public function getStatus() : string
    {
        if ($this->is_active){
            return __('Enabled');
        } else {
            return __('Disabled');
        }
    }

    public function getPrice() : string
    {
       return '$' . round($this->price, 0,  PHP_ROUND_HALF_UP);
    }

    public function getDescription()
    {
        return substr($this->description, 0 , 30);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($product) {
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
    private function getIdCategory(string $category) : int
    {
        (Category::where('name', $category)->exists())
        ? $id = Category::where('name', $category)->first()->id
        : $id = 0;

        return $id;
    }

}
