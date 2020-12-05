<?php

namespace App\Providers;

use App\Constants\Logs;
use App\Constants\Metrics;
use App\Decorators\AdminDecorator;
use Illuminate\Pagination\Paginator;
use App\Decorators\Api\CacheApiProducts;
use App\Decorators\Api\PhotosDecorator;
use App\Decorators\Api\StocksDecorator;
use App\Decorators\CacheCategories;
use App\Decorators\CacheColors;
use App\Decorators\CachePermission;
use App\Decorators\CacheProducts;
use App\Decorators\CacheRoles;
use App\Decorators\CacheSizes;
use App\Decorators\CacheTags;
use App\Decorators\CacheTypeSizes;
use App\Decorators\CacheUsers;
use App\Decorators\GenerateOrder;
use App\Decorators\MetricsDecorator;
use App\Interfaces\AdminInterface;
use App\Interfaces\Api\ApiPhotosInterface;
use App\Interfaces\Api\ApiProductsInterface;
use App\Interfaces\Api\ApiStocksInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ColorsInterface;
use App\Interfaces\MetricsInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\PermissionInterface;
use App\Interfaces\ProductsInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\SizesInterface;
use App\Interfaces\StocksInterface;
use App\Interfaces\TagsInterface;
use App\Interfaces\TypeSizesInterface;
use App\Interfaces\UsersInterface;
use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Repositories\Stocks;
use App\Repositories\Users;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
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
        $this->app->bind(AdminInterface::class, AdminDecorator::class);
        $this->app->bind(UsersInterface::class, CacheUsers::class);
        $this->app->bind(TypeSizesInterface::class, CacheTypeSizes::class);
        $this->app->bind(ApiStocksInterface::class, StocksDecorator::class);
        $this->app->bind(ApiPhotosInterface::class, PhotosDecorator::class);
        $this->app->bind(StocksInterface::class, Stocks::class);
        $this->app->bind(UsersInterface::class, Users::class);
        $this->app->bind(MetricsInterface::class, MetricsDecorator::class);

        Relation::morphMap([
            Metrics::CATEGORIES => Category::class,
            Metrics::SELLER     => Admin::class,
            Metrics::ORDERS     => Order::class,
        ]);

        Paginator::useBootstrap();

        Queue::failing(function (JobFailed $event) {
            logger()->error('Job failed ', [
                'name'      => $event->job->resolveName(),
                'exception' => $event->exception
            ]);
        });
    }
}
