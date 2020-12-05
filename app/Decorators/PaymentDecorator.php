<?php

namespace App\Decorators;

use App\Models\Payer;
use App\Models\Payment;
use App\Repositories\Payments;
use App\Http\Requests\Admin\Payments\StoreRequest;

class PaymentDecorator
{
    public function __construct(Payments $payments)
    {
        $this->payments = $payments;
    }

    /**
     * @param StoreRequest $request
     * @return Payment
     */
    public function createFromAdmin(StoreRequest $request): Payment
    {
        $payment = $this->payments->createFromAdmin($request->get('order_id'), $request->get('method'));

        $payer = Payer::firstorCreate([
            'document' => $request->get('document'),
        ], $request->all());

        $payment->payer_id = $payer->id;
        $payment->reference = $payment->id;
        $payment->save();

        return $payment;
    }
}
