<?php

namespace App\Providers;

use App\Models\Admin\Admin;
use App\Models\Category;
use App\Models\Metric;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Tag;
use App\Models\User;
use App\Policies\Admin\AdminsPolicy;
use App\Policies\Admin\CategoriesPolicy;
use App\Policies\Admin\HomePolicy;
use App\Policies\Admin\OrdersPolicy;
use App\Policies\Admin\PermissionsPolicy;
use App\Policies\Admin\ProductsPolicy;
use App\Policies\Admin\RolePolicy;
use App\Policies\Admin\StocksPolicy;
use App\Policies\Admin\TagsPolicy;
use App\Policies\Admin\UsersPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Role::class         => RolePolicy::class,
        Permission::class   => PermissionsPolicy::class,
        Admin::class        => AdminsPolicy::class,
        User::class         => UsersPolicy::class,
        Category::class     => CategoriesPolicy::class,
        Tag::class          => TagsPolicy::class,
        Stock::class        => StocksPolicy::class,
        Product::class      => ProductsPolicy::class,
        Order::class        => OrdersPolicy::class,
        Metric::class       => HomePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (Admin $admin) {
            if ($admin->isAdmin()) {
                return true;
            }
        });
    }
}
