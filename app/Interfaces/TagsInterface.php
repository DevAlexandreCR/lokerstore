<?php

namespace App\Interfaces;

use App\Http\Requests\Admin\Tags\IndexRequest;

interface TagsInterface extends RepositoryInterface
{
    public function search(IndexRequest $request);
}
