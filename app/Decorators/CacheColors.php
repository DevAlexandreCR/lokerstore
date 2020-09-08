<?php

namespace App\Decorators;

use App\Interfaces\ColorsInterface;
use App\Repositories\Colors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheColors implements ColorsInterface
{
    protected $colors;

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
        $color = $this->colors->store($request);

        Cache::tags(['colors'])->flush();

        return $color;
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        Cache::tags(['colors'])->flush();

        return $model;
    }

    /**
     * @param Model $model
     */
    public function destroy(Model $model)
    {
        $model->delete();
    }
}
