<?php

namespace App\Observers;

use App\Models\Payment;
use App\Repositories\Orders;
use App\Constants\Orders as OrderConstants;

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

    public function created(Payment $payment)
    {
        $this->orders->setStatus($payment->order_id, OrderConstants::STATUS_PENDING_PAY);
    }

}
