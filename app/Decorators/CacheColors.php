<?php

namespace App\Decorators;

use App\Interfaces\ColorsInterface;
use App\Repositories\Colors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheColors implements ColorsInterface
{
    protected Colors $colors;

    public function __construct(Colors $colors)
    {
        $this->colors = $colors;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return Cache::tags(['colors'])->rememberForever('all', function () {
            return $this->colors->index();
        });
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        Cache::tags(['colors'])->flush();

        return $this->colors->store($request);
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        Cache::tags(['colors'])->flush();

        return $model->update($request->all());
    }

    /**
     * @param Model $model
     */
    public function destroy(Model $model)
    {
        $this->colors->destroy($model);
    }
}
