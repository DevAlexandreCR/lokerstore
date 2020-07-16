<?php

namespace App\Models;

use Doctrine\DBAL\Query\QueryBuilder;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name', 'stock', 'description', 'price', 'id_category'
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
        return $this->belongsToMany(Photo::class);
    }

    public function scopeByCategory($query, $category){
        if (empty($category)) return;

        return $query->whereHas('category', function($query) use ($category) {
            return $query->where('name', $category);
        });
    }

    public function scopeWithTags($query, $tags){
        if (empty($tags)) return;

        return $query->whereHas('tags', function($query) use ($tags) {
            foreach ($tags as $key => $value) {
                $query->where('name', $key);
            }
        });
    }

    public function scopeSearch($query, $search) {
        if (empty($search)) return;

        return $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
    }
}
