<?php


namespace App\Decorators;


use App\Interfaces\AdminInterface;
use App\Repositories\Admins;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminDecorator implements AdminInterface
{
    protected $admins;

    public function __construct(Admins $admins)
    {
        $this->admins = $admins;
    }

    public function index()
    {
        return $this->admins->index();
    }

    public function store(Request $request)
    {
        $this->admins->store($request);
    }

    public function update(Request $request, Model $model)
    {
        $this->admins->update($request, $model);
    }

    public function destroy(Model $model)
    {
        $this->admins->destroy($model);
    }
}