<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Constants\Payments as Pay;

class Payments
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function create(int $order_id, int $request_id, string $process_url): Payment
    {
        return $this->payment->updateOrCreate(
            [
               'order_id' => $order_id
            ],
            [
               'request_id' => $request_id,
               'process_url' => $process_url,
               'status' => Pay::STATUS_PENDING
            ]);
    }

    public function setStatus(Payment $payment, string $status)
    {
        return $payment->update([
            'status' => $status
        ]);
    }

    public function setPayReference(Payment $payment, string $pay_reference)
    {
        return $payment->update([
            'pay_reference' => $pay_reference
        ]);
    }
}
