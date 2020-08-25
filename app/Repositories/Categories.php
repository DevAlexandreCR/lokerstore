<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Category;

class Categories implements CategoryInterface
{

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        return $this->category->primaries();
    }

    public function store($request)
    {
        $this->category->create($request->all());
    }

    public function update($request, $model)
    {
        $model->update($request->all());
    }

    public function destroy($model)
    {
        $model->delete();
    }
}
