<?php


namespace App\Repositories;


use App\Http\Requests\Admin\Users\IndexRequest;
use App\Interfaces\UsersInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Users implements UsersInterface
{
    protected User $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }
    public function search(IndexRequest $request)
    {
        $search =  $request->get('search');
        return $this->users->search($search)->paginate(15);
    }

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());
    }

    public function destroy(Model $model)
    {
        $this->users::destroy($model->id);
    }
}
