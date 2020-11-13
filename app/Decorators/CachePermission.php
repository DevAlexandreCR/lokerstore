<?php

namespace App\Decorators;

use App\Interfaces\PermissionInterface;
use App\Repositories\Permissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CachePermission implements PermissionInterface
{
    protected Permissions $permissions;

    public function __construct(Permissions $permissions)
    {
        $this->permissions = $permissions;
    }

    public function index()
    {
        return Cache::tags(['permissions'])->rememberForever('all', function () {
            return $this->permissions->index();
        });
    }

    public function store(Request $request)
    {
        $this->permissions->store($request);

        Cache::tags(['colors'])->flush();
    }

    public function update(Request $request, Model $model)
    {
        $this->permissions->update($request, $model);

        Cache::tags(['permissions'])->flush();
    }

    public function destroy(Model $model)
    {
        $this->permissions->destroy($model);

        Cache::tags(['permissions'])->flush();
    }
}
