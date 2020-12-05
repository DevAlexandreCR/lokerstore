<?php

namespace App\Decorators;

use App\Interfaces\SizesInterface;
use App\Repositories\Sizes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CacheSizes implements SizesInterface
{
    protected Sizes $sizes;

    public function __construct(Sizes $sizes)
    {
        $this->sizes = $sizes;
    }

    public function index()
    {
        return Cache::tags(['sizes'])->rememberForever('all', function () {
            return $this->sizes->index();
        });
    }

    public function store(Request $request)
    {
        $size = $this->sizes->store($request);

        Cache::tags(['sizes'])->flush();

        return $size;
    }

    public function update(Request $request, Model $model)
    {
        $size = $this->sizes->update($request, $model);

        Cache::tags(['sizes'])->flush();

        return $size;
    }

    public function destroy(Model $model)
    {
        $this->sizes->destroy($model);

        Cache::tags(['sizes'])->flush();
    }
}
