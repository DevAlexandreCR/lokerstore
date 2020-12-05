<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPayed extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this
            ->from('payments@lokerstore.com', 'LokerStore')
            ->to($this->order->user->email)
            ->subject(trans('payment.messages.pay_accepted'))
            ->markdown('emails.orders.payed');
    }
}
