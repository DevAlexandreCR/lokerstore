<?php

namespace App\Interfaces;

interface StocksInterface extends RepositoryInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data);
}
