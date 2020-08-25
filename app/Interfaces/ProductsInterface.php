<?php

namespace App\Interfaces;

use App\Http\Requests\Products\ActiveRequest;
use App\Http\Requests\Products\IndexRequest;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Product;

interface ProductsInterface {

    public function index(IndexRequest $request);

    public function store(StoreRequest $request);

    public function update(UpdateRequest $request, Product $product);

    public function setActive(ActiveRequest $request, Product $product);

    public function destroy(Product $product);
}
