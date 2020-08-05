<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index(Request $request): Collection
    {
        return $this->admin->all();
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

        return redirect()->back()->with('success', __('Admin has been created success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Admin  $admin
     * @return Admin
     */
    public function show(Admin $admin): Admin
    {
        return $admin;
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

        return redirect()->back()->with('success', __('Admin has been updated success'));
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

        return redirect()->back()->with('success', __('Admin has been remove success'));
    }
}
