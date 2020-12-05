<?php

namespace App\Interfaces;

use App\Http\Requests\Web\Orders\UpdateRequest;

interface OrderInterface extends RepositoryInterface
{
    /**
     * @param int $order_id
     * @return mixed
     */
    public function find(int $order_id);

    /**
     * @param int $order_id
     * @return mixed
     */
    public function getRequestInformation(int $order_id);

    /**
     * @param UpdateRequest $request
     * @return mixed
     */
    public function resend(UpdateRequest $request);

    /**
     * @param UpdateRequest $request
     * @return mixed
     */
    public function reverse(UpdateRequest $request);
}
