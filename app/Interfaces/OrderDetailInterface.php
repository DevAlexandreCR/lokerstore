<?php

namespace App\Interfaces;

interface OrderDetailInterface
{
    /**
     * @param int $order_id
     * @return mixed
     */
    public function createFromUser(int $order_id);

    /**
     * @param int $order_id
     * @param int $stock_id
     * @param int $quantity
     * @return mixed
     */
    public function createFromAdmin(int $order_id, int $stock_id, int $quantity);
}
