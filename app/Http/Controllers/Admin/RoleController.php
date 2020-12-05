<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\StoreRequest;
use App\Http\Requests\Admin\Roles\UpdateRequest;
use App\Interfaces\PermissionInterface;
use App\Interfaces\RoleInterface;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected RoleInterface $roles;

    public function __construct(RoleInterface $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PermissionInterface $permissions
     * @throws AuthorizationException
     * @return View
     */
    public function index(PermissionInterface $permissions): View
    {
        $this->authorize('index', Role::class);

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

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.role', 1, ['role_count' => '']),
            'status' => trans('fields.created')
        ]));
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

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.role', 1, ['role_count' => '']),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @throws Exception
     * @return RedirectResponse
     */
    public function destroy(Role $role): RedirectResponse
    {
        $this->authorize('destroy', $role);

        $this->roles->destroy($role);

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.role', 1, ['role_count' => '']),
            'status' => trans('fields.deleted')
        ]));
    }
}
