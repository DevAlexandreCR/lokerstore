<?php

namespace App\Policies\Admin;

use App\Constants\Permissions;
use App\Models\Admin\Admin;
use App\Models\Stock;
use Illuminate\Auth\Access\HandlesAuthorization;

class StocksPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any stocks.
     *
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_STOCKS);
    }

    /**
     * Determine whether the user can view the stock.
     *
     * @param Admin $admin
     * @param Stock $stock
     * @return bool
     */
    public function view(Admin $admin, Stock $stock): bool
    {
        return $admin->hasPermissionTo(Permissions::VIEW_STOCKS);
    }

    /**
     * Determine whether the user can create stocks.
     *
     * @param Admin $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasPermissionTo(Permissions::CREATE_STOCKS);
    }

    /**
     * Determine whether the user can update the stock.
     *
     * @param Admin $admin
     * @param Stock $stock
     * @return bool
     */
    public function update(Admin $admin, Stock $stock): bool
    {
        return $admin->hasPermissionTo(Permissions::EDIT_STOCKS);
    }

    /**
     * Determine whether the user can delete the stock.
     *
     * @param Admin $admin
     * @param Stock $stock
     * @return bool
     */
    public function delete(Admin $admin, Stock $stock): bool
    {
        return $admin->hasPermissionTo(Permissions::DELETE_STOCKS);
    }
}
