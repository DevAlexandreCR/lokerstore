<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any categories.
     *
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_CATEGORIES);
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param Admin $admin
     * @param Category $category
     * @return bool
     */
    public function view(Admin $admin, Category $category): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_CATEGORIES);
    }

    /**
     * Determine whether the user can create categories.
     *
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::CREATE_CATEGORIES);
    }

    /**
     * Determine whether the user can update the category.
     *
     * @param Admin $admin
     * @param Category $category
     * @return bool
     */
    public function update(Admin $admin, Category $category): bool
    {
        return $admin->hasPermissionTo(Permissions::EDIT_CATEGORIES);
    }

    /**
     * Determine whether the user can delete the category.
     *
     * @param Admin $admin
     * @param Category $category
     * @return bool
     */
    public function delete(Admin $admin, Category $category): bool
    {
        return $admin->hasPermissionTo(Permissions::DELETE_CATEGORIES);
    }
}
