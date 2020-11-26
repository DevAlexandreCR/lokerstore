<?php

namespace App\Repositories;

use App\Constants\Payments as Pay;
use App\Models\Payer;
use App\Models\Payment;

class Payments
{
    protected Payment $payment;
    protected Payer $payer;

    public function __construct(Payment $payment, Payer $payer)
    {
        $this->payment = $payment;
        $this->payer = $payer;
    }

    /**
     * @param int $order_id
     * @param int|null $request_id
     * @param string|null $process_url
     * @return Payment
     */
    public function create(int $order_id, int $request_id = null, string $process_url = null): Payment
    {
        return $this->payment->updateOrCreate(
            [
               'order_id' => $order_id,
            ],
            [
               'request_id' => $request_id,
               'process_url' => $process_url,
               'status' => Pay::STATUS_PENDING,
            ]
        );
    }

    /**
     * @param int $order_id
     * @param string $method
     * @return Payment
     */
    public function createFromAdmin(int $order_id, string $method): Payment
    {
        return $this->payment->updateOrCreate(
            [
                'order_id' => $order_id,
            ],
            [
                'method' => $method,
                'status' => Pay::STATUS_ACCEPTED,
            ]
        );
    }

    /**
     * @param Payment $payment
     * @param string $status
     * @return bool
     */
    public function setStatus(Payment $payment, string $status): bool
    {
        return $payment->update([
            'status' => $status,
        ]);
    }

    /**
     * @param Payment $payment
     * @param $data
     * @return bool
     */
    public function setDataPayment(Payment $payment, $data): bool
    {
        $pay = $data->payment[0];
        $payer = $data->request->payer;
        $last_digit = $data->payment[0]->processorFields[0]->value;
        $dbPayer = $this->payer->create(
            [
                'document'      => $payer->document,
                'document_type' => $payer->documentType,
                'email'         => $payer->email,
                'name'          => $payer->name,
                'last_name'     => $payer->surname,
                'phone'         => $payer->mobile,
            ]
        );

        return $payment->update([
            'payer_id'   => $dbPayer->id,
            'reference'  => $pay->internalReference,
            'method'     => $pay->paymentMethodName,
            'last_digit' => $last_digit,
        ]);
    }
}
