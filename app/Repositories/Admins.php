<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Interfaces\AdminInterface;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Admins implements AdminInterface
{
    protected Admin $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        return $this->admin::with('roles')->get();
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function store(Request $request)
    {
        $this->admin->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'is_active' => true,
        ]);
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        $model->syncRoles($request->roles);
    }

    /**
     * @param Model $model
     * @return mixed|void
     */
    public function destroy(Model $model)
    {
        $this->admin::destroy($model->id);
    }

    /**
     * @param Admin $admin
     * @return void
     */
    public function updateToken(Admin $admin): void
    {
        $admin->update([
            'api_token' => Str::random(60)
        ]);
    }
}
