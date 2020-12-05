<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Decorators\PaymentDecorator;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Payments\StoreRequest;

class PaymentsController extends Controller
{
    public function store(StoreRequest $request, PaymentDecorator $payments): RedirectResponse
    {
        $payments->createFromAdmin($request);

        return back()->with('success', trans('messages.crud', [
            'resource' => trans('payment.payment'),
            'status' => trans('fields.created')
        ]));
    }
}
