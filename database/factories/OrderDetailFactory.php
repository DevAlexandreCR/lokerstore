<?php

/** @var Factory $factory */

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(OrderDetail::class, function (Faker $faker) {
    $stock = Stock::all()->random();

    return [
        'stock_id' => $stock->id,
        'order_id' => Order::all()->random()->id,
        'quantity' => $quantity = random_int(1, 2),
        'unit_price' => $price = $stock->product->price,
        'total_price' => $price * $quantity,
    ];
});
