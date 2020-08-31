<?php

namespace App\Interfaces;

interface OrderInterface extends RepositoryInterface
{
    public function find(int $user_id, int $order_id);
}
