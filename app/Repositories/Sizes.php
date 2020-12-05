<?php

namespace App\Repositories;

use App\Interfaces\SizesInterface;
use App\Models\Size;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Sizes implements SizesInterface
{
    protected Size $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function index()
    {
        return $this->size::all(['id', 'name', 'type_sizes_id']);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->size->create($request->all());
    }

    /**
     * @param Request $request
     * @param Model $model
     * @return Model|mixed
     */
    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    /**
     * @param Model $model
     * @return mixed|void
     */
    public function destroy(Model $model)
    {
        $this->size::destroy($model->id);
    }
}
