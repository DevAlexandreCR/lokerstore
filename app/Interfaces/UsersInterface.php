<?php


namespace App\Interfaces;


use App\Http\Requests\Admin\Users\IndexRequest;

interface UsersInterface extends RepositoryInterface
{
    public function search(IndexRequest $request);
}
