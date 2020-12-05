<?php

namespace App\Policies\Admin;

use App\Constants\Admins;
use App\Constants\Permissions;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Admin $admin
     * @return bool
     */
    public function index(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_ROLES, Admins::GUARDED);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::CREATE_ROLES, Admins::GUARDED);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param Role $role
     * @return mixed
     */
    public function update(Admin $admin, Role $role)
    {
        return $admin->hasPermissionTo(Permissions::EDIT_ROLES, Admins::GUARDED);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param Role $role
     * @return mixed
     */
    public function destroy(Admin $admin, Role $role)
    {
        return $admin->hasPermissionTo(Permissions::DELETE_ROLES, Admins::GUARDED);
    }
}
