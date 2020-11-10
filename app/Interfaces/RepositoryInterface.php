<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface RepositoryInterface
{

    /**
     * @return mixed
     */
    public function index();

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);

    /**
     * @param Request $request
     * @param Model $model
     * @return mixed
     */
    public function update(Request $request, Model $model);

    /**
     * @param Model $model
     * @return mixed
     */
    public function destroy(Model $model);
}
