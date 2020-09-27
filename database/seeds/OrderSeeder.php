<?php

use App\Constants\Payments;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payer;
use App\Models\Payment;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $orders = factory(Order::class, 10)->create();

        $orders->each( function ($order) {
            $payment = factory(Payment::class)->create([
                'order_id' => $order->id
            ]);

            if ($payment->status === Payments::STATUS_ACCEPTED) {
                factory(Payer::class)->create([
                    'payment_id' => $payment->id
                ]);
            }
            factory(OrderDetail::class, random_int(1,3))->create();
        });
    }
}
