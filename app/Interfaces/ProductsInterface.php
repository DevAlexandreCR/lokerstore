<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Models\Product;

interface ProductsInterface extends RepositoryInterface
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function query(IndexRequest $request);

    /**
     * @param ActiveRequest $request
     * @param Product $product
     * @return mixed
     */
    public function setActive(ActiveRequest $request, Product $product);

    /**
     * @param array $data
     * @return Product|null
     */
    public function create(array $data = []): ?Product;
}
