<?php

namespace App\Interfaces\Api;

use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\RepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ApiProductsInterface extends RepositoryInterface
{

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function query(IndexRequest $request);

    /**
     * @param Product $product
     * @return Collection
     */
    public function show(Product $product): Collection;
}
