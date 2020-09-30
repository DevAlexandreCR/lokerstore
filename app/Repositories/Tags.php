<?php

namespace App\Repositories;

use App\Interfaces\TagsInterface;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Tags\IndexRequest;

class Tags implements TagsInterface
{

    protected Tag $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        return $this->tag::all(['id', 'name']);
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
        $this->tag::destroy($model->id);
    }

    public function search(IndexRequest $request)
    {
        $search = $request->get('search', null);
        return $this->tag
            ->search($search)
            ->with('products')
            ->paginate(15);
    }
}
