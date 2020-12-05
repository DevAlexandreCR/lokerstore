<?php

namespace Database\Seeders;

use App\Constants\Orders;
use Illuminate\Database\Seeder;

class DummyDatabaseSeeder extends Seeder
{
    use \Illuminate\Foundation\Testing\WithFaker;
    /**
     * Seed dummy items to database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call(
            [
                AdminSeeder::class,
                ProductSeeder::class,
                UserSeeder::class,
                StockSeeder::class,
                OrderSeeder::class,
            ]
        );
        \App\Models\Order::all()->each(function ($order) {
            if (now()->subMonth() < $order->created_at) {
                $order->status = $this->makeFaker(config('app.locale'))->randomElement([
                    Orders::STATUS_PENDING_PAY,
                    Orders::STATUS_SUCCESS,
                    Orders::STATUS_SENT,
                    Orders::STATUS_PENDING_SHIPMENT,
                ]);
            } else {
                $order->status = $this->makeFaker(config('app.locale'))->randomElement([
                    Orders::STATUS_CANCELED,
                    Orders::STATUS_SUCCESS,
                ]);
            }
            $order->save();
        });
    }
}
