<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admins\StoreRequest;
use App\Http\Requests\Admin\Admins\UpdateRequest;
use App\Interfaces\AdminInterface;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public AdminInterface $admins;

    public function __construct(AdminInterface $admins)
    {
        $this->admins = $admins;
        $this->authorizeResource(Admin::class, 'admin');
    }

    public function index(): View
    {
        return view('admin.admins.index', [
            'admins' => $this->admins->index(),
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    /**
     * Show current admin
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        $permissions = Permission::pluck('name', 'id');
        $roles = Role::all(['name', 'id']);

        return view('admin.admins.show', compact(['admin', 'permissions', 'roles']));
    }

    /**
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->admins->store($request);

        return redirect()->route('admins.index')->with('success', trans('messages.crud', [
            'resource' => trans('users.admin'),
            'status' => trans('fields.created')
        ]));
    }

    /**
     * Update current admin
     *
     * @param UpdateRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, Admin $admin): RedirectResponse
    {
        $this->admins->update($request, $admin);

        return redirect()->route('admins.show', $admin->id)->with('success', trans('messages.crud', [
            'resource' => trans('users.admin'),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     * Update current admin
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function updateToken(Admin $admin): RedirectResponse
    {
        $this->admins->updateToken($admin);

        return redirect()->route('admins.show', $admin->id)
            ->with('success', trans('messages.crud', [
            'resource' => trans('users.admin'),
            'status' => trans('fields.updated')
        ]));
    }

    /**
     *
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        $this->admins->destroy($admin);

        return redirect()->route('admins.index')->with('success', trans('messages.crud', [
            'resource' => trans('users.admin'),
            'status' => trans('fields.deleted')
        ]));
    }
}
