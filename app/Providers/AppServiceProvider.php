<?php

namespace App\Providers;

use App\Decorators\CacheCategories;
use App\Decorators\CacheProducts;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductsInterface;
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
    }
}
