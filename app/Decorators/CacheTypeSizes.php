<?php


namespace App\Decorators;

use App\Repositories\TypeSizes;
use Illuminate\Support\Facades\Cache;
use App\Interfaces\TypeSizesInterface;

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
