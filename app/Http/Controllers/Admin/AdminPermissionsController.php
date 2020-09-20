<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPermissionsController extends Controller
{
    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $admin->syncPermissions($request->permissions);
        return redirect()->route('admins.show', $admin->id)
            ->with('success', __('Permissions has been added success'));
    }
}
