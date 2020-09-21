<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\StoreRequest;
use App\Http\Requests\Permissions\UpdateRequest;
use App\Interfaces\PermissionInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected $permission;

    public function __construct(PermissionInterface $permission)
    {
        $this->permission = $permission;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->permission->store($request);

        return redirect()->route('roles.index')->with('success', __('Permission has been created successfully'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Permission $permission): RedirectResponse
    {
        $this->permission->update($request, $permission);

        return redirect()->route('roles.index')->with('success', __('Permission has been created successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $this->permission->destroy($permission);

        return redirect()->route('roles.index')->with('success', __('Permission has been removed successfully'));
    }
}
