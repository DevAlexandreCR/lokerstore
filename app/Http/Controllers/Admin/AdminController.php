<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index(): View
    {
        return view('admin.admins.index', [
            'admins' => $this->admin::all(),
            'roles' => Role::pluck('name', 'id')
        ]);
    }

    public function show(Admin $admin): View
    {
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::all(['name', 'id']);
        return view('admin.admins.show', compact(['admin', 'permissions', 'roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->admin->create($request->all());

        return redirect()->route('admins.index')->with('success', __('Admin has been created success'));
    }

    /**
     * Update current admin
     *
     * @param Request $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $admin->update($request->all());

        $admin->syncRoles($request->roles);

        return redirect()->route('admins.show', $admin->id)->with('success', __('User has been updated success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        $admin->delete();

        return redirect()->route('admins.index')->with('success', __('Admin has been remove success'));
    }
}
