<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrdersPolicy
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
        return $admin->hasPermissionTo(Permissions::VIEW_ORDERS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param Admin $admin
     * @param Order $order
     * @return mixed
     */
    public function view(Admin $admin, Order $order)
    {
        return $admin->hasPermissionTo(Permissions::VIEW_ORDERS);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param Admin $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        return $admin->hasPermissionTo(Permissions::CREATE_ORDERS);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param Admin $admin
     * @param Order $order
     * @return mixed
     */
    public function update(Admin $admin, Order $order)
    {
        return $admin->hasPermissionTo(Permissions::EDIT_ORDERS);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param Admin $admin
     * @param Order $order
     * @return mixed
     */
    public function delete(Admin $admin, Order $order)
    {
        return $admin->hasPermissionTo(Permissions::DELETE_ORDERS);
    }
}
