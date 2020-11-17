<?php

/** @var Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->randomFloat(2, 15000, 100000);

    return [
        'reference' => $faker->unique()->numberBetween(1000, 9999),
        'name' => $faker->firstName,
        'description' => $faker->sentence(10),
        'stock' => 0,
        'cost' => $cost,
        'price' => $faker->randomFloat(2, $cost, $cost + $cost * 0.5),
        'id_category' => Category::subCategories()->random()->id,
        'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
    ];
});
