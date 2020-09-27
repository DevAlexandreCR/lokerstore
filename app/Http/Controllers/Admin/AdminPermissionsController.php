<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\UpdatePermissionsRequest;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;

class AdminPermissionsController extends Controller
{
    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function update(UpdatePermissionsRequest $request, Admin $admin): RedirectResponse
    {
        $admin->syncPermissions($request->permissions);
        return redirect()->route('admins.show', $admin->id)
            ->with('success', __('Permissions has been updated success'));
    }
}