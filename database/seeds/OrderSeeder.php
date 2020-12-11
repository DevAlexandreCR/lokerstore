<?php

namespace Database\Seeders;

use App\Constants\Payments;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payer;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;

class OrderSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run(): void
        {
            factory(OrderDetail::class, 500)->create();

            Order::all()->each(function ($order) {
                factory(Payment::class)->create([
                    'order_id' => $order->id,
                    'status'   => Payments::STATUS_ACCEPTED
                ]);
                Artisan::call('queue:clear');
                $order->orderDetails->each(function ($detail) use ($order) {
                    $order->amount += $detail->total_price;
                });
                $order->save();
            });
        }
    }
