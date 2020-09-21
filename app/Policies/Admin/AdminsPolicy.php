<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Admin $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return $user->hasPermissionTo(Permissions::VIEW_ADMINS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Admin $user
     * @param Admin $admin
     * @return mixed
     */
    public function view(Admin $user, Admin $admin)
    {
        return $user->hasPermissionTo(Permissions::VIEW_ADMINS) || $user->id === $admin->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return $user->hasPermissionTo(Permissions::CREATE_ADMINS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $user
     * @param Admin $admin
     * @return mixed
     */
    public function update(Admin $user, Admin $admin)
    {
        return $user->hasPermissionTo(Permissions::EDIT_ADMINS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $user
     * @param Admin $admin
     * @return mixed
     */
    public function delete(Admin $user, Admin $admin)
    {
        return $user->hasPermissionTo(Permissions::DELETE_ADMINS);
    }
}
