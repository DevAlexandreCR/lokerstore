<?php


namespace App\Repositories;


use App\Constants\Admins;
use App\Interfaces\RoleInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use function GuzzleHttp\Promise\all;

class Roles implements RoleInterface
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function index()
    {
        return $this->role::all(['id', 'name']);
    }

    public function store(Request $request)
    {
        $this->role::create([
            'name'       => $request->get('name'),
            'guard_name' => Admins::GUARDED
        ]);
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        $model->syncPermissions($request->permissions);
    }

    public function destroy(Model $model)
    {
        $model->delete();
    }
}
