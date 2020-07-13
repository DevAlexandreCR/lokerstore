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

    public function scopeByCategory($query, $name){
        if (empty($name)) return;

        return $query->whereHas('category', function($query) use ($name) {
            return $query->where('name', $name);
        });
    }

    public function scopeWithTags($query, $tags){
        if (empty($tags)) return;

        return $query->whereHas('tags', function($query) use ($tags) {
            foreach ($tags as $tag) {
                $query->where('name', $tag);
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
