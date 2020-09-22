<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
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
        return $admin->hasPermissionTo(Permissions::VIEW_USERS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Admin $admin
     * @param User $user
     * @return bool
     */
    public function view(Admin $admin, User $user): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_USERS);
    }

    /**
     * Determine whether the user can create users.
     *
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::CREATE_USERS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param User $user
     * @return bool
     */
    public function update(Admin $admin, User $user): bool
    {
        return $admin->hasPermissionTo(Permissions::EDIT_USERS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param User $user
     * @return bool
     */
    public function delete(Admin $admin, User $user): bool
    {
        return $admin->hasPermissionTo(Permissions::DELETE_USERS);
    }
}
