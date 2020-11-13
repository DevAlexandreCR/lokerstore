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

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function search(IndexRequest $request)
    {
        $search =  $request->get('search');

        return $this->users
            ->search($search)
            ->paginate(15);
    }

    public function index()
    {
        return $this->users::all('id');
    }

    public function store(Request $request)
    {
        // TODO: Implement store() method.
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());
    }

    /**
     * @param Model $model
     * @return mixed|void
     */
    public function destroy(Model $model)
    {
        $this->users::destroy($model->id);
    }
}
