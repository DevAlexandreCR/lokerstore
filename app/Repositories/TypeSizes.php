<?php

namespace App\Repositories;

use App\Models\TypeSize;
use App\Interfaces\TypeSizesInterface;

class TypeSizes implements TypeSizesInterface
{
    protected TypeSize $typeSizes;

    public function __construct(TypeSize $typeSizes)
    {
        $this->typeSizes = $typeSizes;
    }

    public function all()
    {
        return $this->typeSizes::with('sizes')->get();
    }
}
