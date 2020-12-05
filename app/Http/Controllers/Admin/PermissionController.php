<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permissions\StoreRequest;
use App\Http\Requests\Admin\Permissions\UpdateRequest;
use App\Interfaces\PermissionInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    protected PermissionInterface $permission;

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

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.permission', 1, ['permission_count' => '']),
            'status' => trans('fields.created')
        ]));
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

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.permission', 1, ['permission_count' => '']),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @throws AuthorizationException
     * @return RedirectResponse
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $this->authorize('delete', $permission);

        $this->permission->destroy($permission);

        return redirect()->route('roles.index')->with('success', trans('messages.crud', [
            'resource' => trans_choice('roles.permission', 1, ['permission_count' => '']),
            'status' => trans('fields.deleted')
        ]));
    }
}
