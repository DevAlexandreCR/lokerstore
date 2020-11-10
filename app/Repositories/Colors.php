<?php

namespace App\Repositories;

use App\Interfaces\ColorsInterface;
use App\Models\Color;
use Illuminate\Database\Eloquent\Model;

class Colors implements ColorsInterface
{
    protected Color $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->color::all(['id', 'name', 'code']);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function store($request)
    {
        return $this->color->create($request->all());
    }

    /**
     * @param $request
     * @param Model $model
     * @return mixed
     */
    public function update($request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    /**
     * @param Model $model
     * @return void
     */
    public function destroy(Model $model): void
    {
        $this->color::destroy($model->id);
    }
}
