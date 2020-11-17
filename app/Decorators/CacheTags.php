<?php

namespace App\Decorators;

use App\Http\Requests\Admin\Tags\IndexRequest;
use App\Interfaces\TagsInterface;
use App\Repositories\Tags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheTags implements TagsInterface
{
    protected Tags $tags;

    public function __construct(Tags $tags)
    {
        $this->tags = $tags;
    }

    public function index()
    {
        return Cache::tags(['tags'])->rememberForever('all', function () {
            return $this->tags->index();
        });
    }

    public function store(Request $request)
    {
        Cache::tags(['tags'])->flush();

        return $this->tags->store($request);
    }

    public function update(Request $request, Model $model)
    {
        Cache::tags(['tags'])->flush();

        return $this->tags->update($request, $model);
    }

    public function destroy(Model $model)
    {
        Cache::tags(['tags'])->flush();

        $this->tags->destroy($model);
    }

    public function search(IndexRequest $request)
    {
        $search = $request->get('search', null);

        return Cache::tags(['tags'])->rememberForever($search, function () use ($request) {
            return $this->tags->search($request);
        });
    }
}
