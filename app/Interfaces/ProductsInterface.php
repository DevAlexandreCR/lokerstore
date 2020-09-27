<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Products\ActiveRequest;
use App\Http\Requests\Admin\Products\IndexRequest;
use App\Models\Product;

interface ProductsInterface extends RepositoryInterface
{

    public function query(IndexRequest $request);

    public function setActive(ActiveRequest $request, Product $product);

}
