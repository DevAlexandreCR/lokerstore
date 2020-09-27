<?php

namespace App\Repositories;

use App\Models\Payer;
use App\Models\Payment;
use App\Constants\Payments as Pay;

class Payments
{
    protected $payment;
    protected $payer;

    public function __construct(Payment $payment, Payer $payer)
    {
        $this->payment = $payment;
        $this->payer = $payer;
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

    public function setStatus(Payment $payment, string $status): bool
    {
        return $payment->update([
            'status' => $status
        ]);
    }

    /**
     * @param Payment $payment
     * @param $data
     * @return bool
     */
    public function setDataPayment(Payment $payment, $data)
    {
        $pay = $data->payment[0];
        $payer = $data->request->payer;
        $last_digit = $data->payment[0]->processorFields[0]->value;
        $this->payer->create(
            [
                'payment_id'    => $payment->id,
                'document'      => $payer->document,
                'document_type' => $payer->documentType,
                'email'         => $payer->email,
                'name'          => $payer->name,
                'last_name'     => $payer->surname,
                'phone'         => $payer->mobile,
            ]);
        return $payment->update([
            'reference'  => $pay->internalReference,
            'method'     => $pay->paymentMethodName,
            'last_digit' => $last_digit
        ]);
    }
}
