<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::VIEW_HOME);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::CREATE_METRICS);
    }
}
