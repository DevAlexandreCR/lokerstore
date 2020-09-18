<?php


namespace App\Repositories;


use App\Constants\Admins;
use App\Interfaces\PermissionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class Permissions implements PermissionInterface
{
    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function index()
    {
        return $this->permission::pluck('name', 'id');
    }

    public function store(Request $request)
    {
        $this->permission::create([
            'name'       => $request->get('name'),
            'guard_name' => Admins::GUARDED
        ]);
    }

    public function update(Request $request, Model $model)
    {
        $model->update([
            'name' => $request->get('name'),
        ]);
    }

    public function destroy(Model $model)
    {
        $model->delete();
    }
}
