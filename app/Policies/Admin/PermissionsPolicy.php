<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::VIEW_PERMISSIONS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param Permission $permission
     * @return mixed
     */
    public function update(Admin $admin, Permission $permission)
    {
        return $admin->hasPermissionTo(Permissions::VIEW_PERMISSIONS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param Permission $permission
     * @return mixed
     */
    public function delete(Admin $admin, Permission $permission)
    {
        return $admin->hasPermissionTo(Permissions::DELETE_PERMISSIONS);
    }
}
