<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{   
    protected $table = 'products';

    protected $fillable = [
        'name', 'stock', 'description', 'price', 'id_category', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function scopeByCategory($query, $category)
    {
        if (empty($category)) return;

        // $cat = Category::find()

        $query->whereHas('category', function($query) use ($category) {
               $categoryModel = $query->where('name', $category)->getModel();
               $cat = $categoryModel->with('children')->where('name', $category);
               return $cat->with('products')->get();
            });
    }

    public function scopeWithTags($query, $tags)
    {
        if (empty($tags)) return;

        return $query->whereHas('tags', function($query) use ($tags) {
            foreach ($tags as $key => $value) {
                $query->where('name', $key);
            }
        });
    }

    public function scopeSearch($query, $search) 
    {
        if (empty($search)) return;

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
}
