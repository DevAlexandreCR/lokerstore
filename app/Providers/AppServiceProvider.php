<?php

namespace App\Providers;

use App\Decorators\Api\CacheApiProducts;
use App\Decorators\CacheCategories;
use App\Decorators\CacheColors;
use App\Decorators\CacheProducts;
use App\Decorators\CacheSizes;
use App\Decorators\CacheTags;
use App\Interfaces\Api\ApiProductsInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ColorsInterface;
use App\Interfaces\ProductsInterface;
use App\Interfaces\SizesInterface;
use App\Interfaces\TagsInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProductsInterface::class, CacheProducts::class);
        $this->app->bind(CategoryInterface::class, CacheCategories::class);
        $this->app->bind(TagsInterface::class, CacheTags::class);
        $this->app->bind(ColorsInterface::class, CacheColors::class);
        $this->app->bind(SizesInterface::class, CacheSizes::class);
        $this->app->bind(ApiProductsInterface::class, CacheApiProducts::class);
    }
}
