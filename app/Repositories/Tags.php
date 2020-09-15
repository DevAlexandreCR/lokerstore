<?php

namespace App\Repositories;

use App\Interfaces\TagsInterface;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Tags implements TagsInterface
{

    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        return $this->tag::all();
    }

    public function store(Request $request)
    {
        return $this->tag->create($request->all());
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
