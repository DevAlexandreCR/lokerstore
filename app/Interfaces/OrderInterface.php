<?php

namespace App\Interfaces;

use App\Http\Requests\Orders\UpdateRequest;
use App\Models\Order;

interface OrderInterface extends RepositoryInterface
{
    public function find(int $user_id, int $order_id);

    public function getRequestInformation(UpdateRequest $request);
}
