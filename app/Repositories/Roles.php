<?php

namespace App\Repositories;

use App\Constants\Admins;
use App\Interfaces\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class Roles implements RoleInterface
{
    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        return $this->role::all(['id', 'name']);
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function store(Request $request)
    {
        $this->role::create([
            'name'       => $request->get('name'),
            'guard_name' => Admins::GUARDED,
        ]);
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed|void
     */
    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        $model->syncPermissions($request->permissions);
    }

    /**
     * @param Model $model
     * @return mixed|void
     */
    public function destroy(Model $model)
    {
        $this->role::destroy($model->id);
    }
}
