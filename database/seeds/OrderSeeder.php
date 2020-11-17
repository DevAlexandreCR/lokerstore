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
         * @throws Exception
         * @return void
         */
        public function run(): void
        {
            $orders = factory(Order::class, 100)->create();

            $orders->each(function ($order) {
                factory(OrderDetail::class, random_int(1, 3))->create([
                    'order_id' => $order->id,
                ]);

                $payer = factory(Payer::class)->create();

                factory(Payment::class)->create([
                    'order_id' => $order->id,
                    'status'   => Payments::STATUS_ACCEPTED,
                    'payer_id' => $payer->id,
                ]);
            });
        }
    }
