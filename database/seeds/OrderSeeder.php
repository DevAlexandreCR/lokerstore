<?php

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\User;
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
            factory(Payment::class)->create([
                'order_id' => $order->id
            ]);
            factory(OrderDetail::class, random_int(1,3))->create();
        });
    }
}
