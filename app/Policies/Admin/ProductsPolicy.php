<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function view(Admin $admin, Product $product): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_PRODUCTS);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::CREATE_PRODUCTS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function update(Admin $admin, Product $product): bool
    {
        return $admin->hasPermissionTo(Permissions::EDIT_PRODUCTS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function delete(Admin $admin, Product $product): bool
    {
        return $admin->hasPermissionTo(Permissions::DELETE_PRODUCTS);
    }
}
