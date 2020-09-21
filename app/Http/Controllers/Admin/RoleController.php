<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Roles\StoreRequest;
use App\Http\Requests\Roles\UpdateRequest;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $roles;

    public function __construct(RoleInterface $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PermissionInterface $permissions
     * @return View
     */
    public function index(PermissionInterface $permissions): View
    {
        return view('admin.roles.index', [
            'roles' => $this->roles->index(),
            'permissions' => $permissions->index(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->roles->store($request);

        return redirect()->route('roles.index')->with('success', __('Role has been created successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Role $role): RedirectResponse
    {
        $this->roles->update($request, $role);

        return redirect()->route('roles.index')->with('success', __('Role has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->roles->destroy($role);

        return redirect()->route('roles.index')->with('success', __('Role has been removed successfully'));
    }
}
