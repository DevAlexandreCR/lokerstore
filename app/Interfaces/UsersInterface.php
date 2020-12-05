<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Users\IndexRequest;

interface UsersInterface extends RepositoryInterface
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function search(IndexRequest $request);
}
