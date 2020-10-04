<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Tags\IndexRequest;

interface TagsInterface extends RepositoryInterface
{
    /**
     * @param IndexRequest $request
     * @return mixed
     */
    public function search(IndexRequest $request);
}
