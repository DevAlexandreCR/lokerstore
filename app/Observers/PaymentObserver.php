<?php

namespace App\Observers;

use App\Models\Payment;
use App\Repositories\Orders;

class PaymentObserver
{

    protected $orders;

    public function __construct(Orders $orders)
    {
        $this->orders = $orders;
    }

    /**
     * Update status of order when change status payment
     *
     * @param  Payment  $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        $status = $this->orders->getStatusFromStatusPayment($payment->status);
        $this->orders->setStatus($payment->order_id, $status);
    }

}
