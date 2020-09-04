<?php

namespace App\Interfaces;

use App\Http\Requests\Orders\UpdateRequest;

interface OrderInterface extends RepositoryInterface
{
    public function find(int $order_id);

    public function getRequestInformation(int $order_id);

    public function resend(UpdateRequest $request);

    public function reverse(UpdateRequest $request);
}
