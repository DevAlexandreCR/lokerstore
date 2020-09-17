<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use http\Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return view('admin.roles.index', [
            'roles' => Role::pluck('name', 'id'),
            'permissions' => Permission::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->role::create([
            'name' => $request->get('name'),
            'guard_name' => $request->get('guard_name')
        ]);

        return redirect()->route('roles.index')->with('success', __('Role has been created successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $role->update($request->all());

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
        $role->delete();

        return redirect()->route('roles.index')->with('success', __('Role has been removed successfully'));
    }
}
