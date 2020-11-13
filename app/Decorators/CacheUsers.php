<?php

namespace App\Decorators;

use App\Http\Requests\Admin\Users\IndexRequest;
use App\Interfaces\UsersInterface;
use App\Repositories\Users;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheUsers implements UsersInterface
{
    protected Users $users;

    public function __construct(Users $users)
    {
        $this->users = $users;
    }

    public function search(IndexRequest $request)
    {
        $search =  $request->get('search');

        return Cache::tags('users')->rememberForever($search, function () use ($request) {
            return $this->users->search($request);
        });
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
        Cache::tags('users')->flush();
        $this->users->update($request, $model);
    }

    public function destroy(Model $model)
    {
        Cache::tags('users')->flush();
        $this->users->destroy($model);
    }
}
