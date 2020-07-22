<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name', 'id_parent'];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'id_parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'id_parent');
    }

    public static function primaries()
    {
        return Category::all()->where('id_parent', '==', null);
    }

    public static function subCategories()
    {
        return Category::all()->where('id_parent', '!=', null);
    }

    public function getFullCategory()
    {
        return $this->parent->name . ' - ' . $this->name;
    }
}
