<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Categories implements CategoryInterface
{
    protected Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return $this->category::primaries();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->category->create($request->all());
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
        $this->category::destroy($model->id);
    }

    /**
     * @return Category[]|Collection|mixed
     */
    public function all()
    {
        return $this->category::all();
    }
}
