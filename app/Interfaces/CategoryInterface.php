<?php

namespace App\Interfaces;

interface CategoryInterface extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function all();
}
