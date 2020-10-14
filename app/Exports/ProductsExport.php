<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductsExport implements FromQuery
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Product::query();
    }
}
