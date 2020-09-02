<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Color;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Size;
use Faker\Generator as Faker;

$factory->define(OrderDetail::class, function (Faker $faker) {
    return [
        'product_id' => Product::all()->random()->id,
        'order_id' => Order::all()->random()->id,
        'color_id' => Color::all()->random()->id,
        'size_id' => Size::all()->random()->id,
        'quantity' => 1,
        'unit_price' => rand(10000,100000),
        'total_price' => 100000
    ];
});
