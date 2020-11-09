<?php

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
                OrderSeeder::class
            ]
        );
        \App\Models\Order::all()->each(function ($order){
            $order->status = $this->makeFaker(config('app.locale'))->randomElement([
                Orders::STATUS_CANCELED,
                Orders::STATUS_SUCCESS
            ]);
            $order->save();
        });
    }
}
