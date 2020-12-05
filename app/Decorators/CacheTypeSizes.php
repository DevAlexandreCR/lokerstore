<?php

namespace App\Decorators;

use App\Interfaces\TypeSizesInterface;
use App\Repositories\TypeSizes;
use Illuminate\Support\Facades\Cache;

class CacheTypeSizes implements TypeSizesInterface
{
    protected TypeSizes $typeSizes;

    public function __construct(TypeSizes $typeSizes)
    {
        $this->typeSizes = $typeSizes;
    }

    public function all()
    {
        return Cache::tags('typeSizes')->rememberForever('all', function () {
            return $this->typeSizes->all();
        });
    }
}
