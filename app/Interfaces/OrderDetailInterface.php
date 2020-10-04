<?php

namespace App\Interfaces;

interface OrderDetailInterface
{
    /**
     * @param int $order_id
     * @return mixed
     */
    public function create(int $order_id);
}
