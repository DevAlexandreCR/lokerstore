<?php

namespace App\Repositories;

use App\Interfaces\SizesInterface;
use App\Models\Size;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Sizes implements SizesInterface
{

    protected $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function index()
    {
        return $this->size::all(['id', 'name', 'type_sizes_id']);
    }

    public function store(Request $request)
    {
        return $this->size->create($request->all());
    }

    public function update(Request $request, Model $model)
    {
        $model->update($request->all());

        return $model;
    }

    public function destroy(Model $model)
    {
        $model->delete();
    }
}
