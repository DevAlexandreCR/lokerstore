<?php


namespace App\Repositories;


use App\Interfaces\AdminInterface;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Admins implements AdminInterface
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function index()
    {
        return $this->admin::all();
    }

    public function store(Request $request)
    {
        $this->admin->create($request->all());
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        $model->syncRoles($request->roles);
    }

    public function destroy(Model $model)
    {
        $model->delete();
    }
}
