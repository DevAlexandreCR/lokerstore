<?php

    use App\Constants\Orders;
    use App\Constants\Payments;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payer;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;

    class OrderSeeder extends Seeder
{
    use WithFaker;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $orders = factory(Order::class, 500)->create();

        $orders->each( function ($order) {
            factory(OrderDetail::class, random_int(1,3))->create([
                'order_id' => $order->id
            ]);
            $payment = factory(Payment::class)->create([
                'order_id' => $order->id
            ]);

            if ($payment->status === Payments::STATUS_ACCEPTED) {
                factory(Payer::class)->create([
                    'payment_id' => $payment->id
                ]);
                $order->status = $this->makeFaker('es')->randomElement([Orders::STATUS_SENT, Orders::STATUS_PENDING_SHIPMENT]);
                $order->save();
            }
        });
    }
}
