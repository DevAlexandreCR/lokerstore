<?php

namespace App\Interfaces\Api;

use App\Http\Requests\Products\IndexRequest;
use App\Interfaces\RepositoryInterface;

interface ApiProductsInterface extends RepositoryInterface
{
    public function query(IndexRequest $request);
}
