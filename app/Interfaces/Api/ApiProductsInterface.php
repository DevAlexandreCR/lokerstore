<?php

namespace App\Interfaces\Api;

use App\Http\Requests\Admin\Products\IndexRequest;
use App\Interfaces\RepositoryInterface;

interface ApiProductsInterface extends RepositoryInterface
{

    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function query(IndexRequest $request);
}
