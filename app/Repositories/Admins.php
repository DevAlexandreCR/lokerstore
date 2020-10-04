<?php


namespace App\Repositories;


use App\Interfaces\AdminInterface;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        $this->admin->create($request->all());
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
}
