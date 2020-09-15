<?php

/** @var Factory $factory */

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderDetail::class, function (Faker $faker) {
    return [
        'stock_id' => Stock::all()->random()->id,
        'order_id' => Order::all()->random()->id,
        'quantity' => 1,
        'unit_price' => random_int(10000,100000),
        'total_price' => 100000
    ];
});
