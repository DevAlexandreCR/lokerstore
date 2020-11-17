<?php

namespace App\Policies\Admin;

use App\Models\Payment;
use App\Models\User;
use App\Models\Admin\Admin;
use App\Constants\Permissions;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentsPolicy
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
        return $admin->hasPermissionTo(Permissions::VIEW_PAYMENTS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Admin $admin
     * @param Payment $payment
     * @return mixed
     */
    public function view(Admin $admin, Payment $payment)
    {
        return $admin->hasPermissionTo(Permissions::VIEW_PAYMENTS);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::CREATE_PAYMENTS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param Payment $payment
     * @return mixed
     */
    public function update(Admin $admin, Payment $payment)
    {
        return $admin->hasPermissionTo(Permissions::EDIT_PAYMENTS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param Payment $payment
     * @return mixed
     */
    public function delete(Admin $admin, Payment $payment)
    {
        return $admin->hasPermissionTo(Permissions::DELETE_PAYMENTS);
    }
}
