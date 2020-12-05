<?php

/** @var Factory $factory */

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'product_id' => Product::all()->random()->id,
        'color_id' => Color::all()->random()->id,
        'size_id' => Size::all()->random()->id,
        'quantity'    => random_int(30, 50),
    ];
});
