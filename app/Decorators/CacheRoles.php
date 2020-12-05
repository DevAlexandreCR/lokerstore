<?php

namespace App\Decorators;

use App\Interfaces\RoleInterface;
use App\Repositories\Roles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheRoles implements RoleInterface
{
    protected Roles $roles;

    public function __construct(Roles $roles)
    {
        $this->roles = $roles;
    }
    public function index()
    {
        return Cache::tags(['roles'])->rememberForever('all', function () {
            return $this->roles->index();
        });
    }

    public function store(Request $request)
    {
        $this->roles->store($request);

        Cache::tags(['roles'])->flush();
    }

    public function update(Request $request, Model $model)
    {
        $this->roles->update($request, $model);

        Cache::tags(['roles'])->flush();
    }

    public function destroy(Model $model)
    {
        $this->roles->destroy($model);

        Cache::tags(['roles'])->flush();
    }
}
