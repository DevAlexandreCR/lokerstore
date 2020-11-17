<?php

namespace App\Repositories;

use App\Http\Requests\Admin\Tags\IndexRequest;
use App\Interfaces\TagsInterface;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->tag->create($request->all());
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
        $this->tag::destroy($model->id);
    }

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function search(IndexRequest $request)
    {
        $search = $request->get('search', null);

        return $this->tag
            ->search($search)
            ->with('products')
            ->paginate(15);
    }
}
