<?php

namespace App\Decorators;

use App\Interfaces\TagsInterface;
use App\Repositories\Tags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheTags implements TagsInterface
{

    protected $tags;

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
        $tag = $this->tags->store($request);

        Cache::tags(['tags'])->flush();

        return $tag;
    }

    public function update(Request $request, Model $model)
    {
        $tag = $this->tags->update($request, $model);

        Cache::tags(['tags'])->flush();

        return $tag;
    }

    public function destroy(Model $model)
    {
        $this->tags->destroy();
    }
}
