<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'product_id' => Product::all()->random()->id,
        'color_id' => Color::all()->random()->id,
        'size_id' => Size::all()->random()->id,
        'quantity' => range(1, 10)
    ];
});
