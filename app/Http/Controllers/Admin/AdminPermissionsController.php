<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\UpdatePermissionsRequest;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;

class AdminPermissionsController extends Controller
{
    public Admin $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Update the permissions to admin
     *
     * @param UpdatePermissionsRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(UpdatePermissionsRequest $request, Admin $admin): RedirectResponse
    {
        $admin->syncPermissions($request->permissions);

        return redirect()->route('admins.show', $admin->id)
            ->with('success', trans('messages.crud', [
                'resource' => trans_choice('roles.permission', 1, ['permission_count' => '']),
                'status' => trans('fields.updated')
            ]));
    }
}
