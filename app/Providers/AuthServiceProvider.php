<?php

namespace App\Providers;

use App\Models\Admin\Admin;
use App\Policies\Admin\AdminsPolicy;
use App\Policies\Admin\PermissionsPolicy;
use App\Policies\Admin\RolePolicy;
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
        Admin::class   => AdminsPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function(Admin $admin) {
           if ($admin->isAdmin()) {
               return true;
           }
        });
    }
}
