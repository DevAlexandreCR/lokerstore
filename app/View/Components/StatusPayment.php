<?php

namespace App\View\Components;

use App\Models\Order;
use Illuminate\View\Component;
use Illuminate\View\View;

class StatusPayment extends Component
{
    public Order $order;

    /**
     * Create a new component instance.
     *
     * @param $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.status-payment');
    }
}
