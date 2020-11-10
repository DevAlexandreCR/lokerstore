<?php

namespace App\Decorators;

use App\Interfaces\CategoryInterface;
use App\Repositories\Categories;
use Illuminate\Support\Facades\Cache;

class CacheCategories implements CategoryInterface
{
    protected Categories $categories;

    public function __construct(Categories $categories)
    {
        $this->categories = $categories;
    }

    public function index()
    {
        return Cache::tags(['categories'])->rememberForever('primaries', function () {
            return $this->categories->index();
        });
    }

    public function store($request)
    {
        $this->categories->store($request);

        Cache::tags(['categories'])->flush();
    }

    public function update($request, $model)
    {
        $this->categories->update($request, $model);

        Cache::tags(['categories'])->flush();
    }

    public function destroy($model)
    {
        $this->categories->destroy($model);

        Cache::tags(['categories'])->flush();
        Cache::tags(['products', 'api.products'])->flush();
    }

    public function all()
    {
        return Cache::tags(['categories'])->rememberForever('all', function () {
            return $this->categories->all();
        });
    }
}
