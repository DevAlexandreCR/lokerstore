<?php

namespace App\Observers;

use App\Models\Payment;
use App\Constants\Payments;
use App\Repositories\Orders;
use App\Actions\Metrics\AddMetricOrders;
use App\Actions\Metrics\AddMetricSellers;

class PaymentObserver
{
    protected Orders $orders;

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
    public function updated(Payment $payment): void
    {
        $status = $this->orders->getStatusFromStatusPayment($payment->status);
        $this->orders->setStatus($payment->order_id, $status);
    }

    public function created(Payment $payment): void
    {
        $status = $this->orders->getStatusFromStatusPayment($payment->status);
        $this->orders->setStatus($payment->order_id, $status);
    }
}
