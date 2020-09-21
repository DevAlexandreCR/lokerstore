<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\Interfaces\AdminInterface;
use App\Models\Admin\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public $admins;

    public function __construct(AdminInterface $admins)
    {
        $this->admins = $admins;
    }

    public function index(): View
    {
        return view('admin.admins.index', [
            'admins' => $this->admins->index(),
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
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $this->admins->store($request);

        return redirect()->route('admins.index')->with('success', __('Admin has been created success'));
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
        $this->admins->destroy($admin);

        return redirect()->route('admins.index')->with('success', __('Admin has been remove success'));
    }
}
