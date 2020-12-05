<?php

namespace App\Repositories;

use App\Models\Cart;

class Carts
{
    protected Cart $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCart(int $id)
    {
        return $this->cart
            ->cart($id)
            ->with('stocks')
            ->first();
    }
}
