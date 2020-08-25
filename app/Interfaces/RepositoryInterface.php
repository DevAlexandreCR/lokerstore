<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

    public function index();

    public function store($request);

    public function update($request, Model $model);

    public function destroy(Model $model);
}
