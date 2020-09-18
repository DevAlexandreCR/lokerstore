<?php

namespace App\Providers;

use App\Decorators\Api\CacheApiProducts;
use App\Decorators\CacheCategories;
use App\Decorators\CacheColors;
use App\Decorators\CachePermission;
use App\Decorators\CacheProducts;
use App\Decorators\CacheRoles;
use App\Decorators\CacheSizes;
use App\Decorators\CacheTags;
use App\Decorators\GenerateOrder;
use App\Interfaces\Api\ApiProductsInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ColorsInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\ProductsInterface;
use App\Interfaces\RoleInterface;
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
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->app->bind(ProductsInterface::class, CacheProducts::class);
        $this->app->bind(CategoryInterface::class, CacheCategories::class);
        $this->app->bind(TagsInterface::class, CacheTags::class);
        $this->app->bind(ColorsInterface::class, CacheColors::class);
        $this->app->bind(SizesInterface::class, CacheSizes::class);
        $this->app->bind(ApiProductsInterface::class, CacheApiProducts::class);
        $this->app->bind(OrderInterface::class, GenerateOrder::class);
        $this->app->bind(PermissionInterface::class, CachePermission::class);
        $this->app->bind(RoleInterface::class, CacheRoles::class);
    }
}
