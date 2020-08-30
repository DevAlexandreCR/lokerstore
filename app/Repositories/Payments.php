<?php

namespace App\Repositories;

use App\Models\Payment;

class Payments
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function create(int $order_id, int $request_id, string $process_url): Payment
    {
        return $this->payment->create([
                   'order_id' => $order_id,
                   'request_id' => $request_id,
                   'process_url' => $process_url
                ]);
    }
}
