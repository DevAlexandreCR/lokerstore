<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence(10),
        'stock' => rand(1, 20),
        'price' => $faker->randomFloat(2, 20000, 200000),
        'id_category' => Category::subCategories()->random()->id,
        'created_at' => $faker->dateTimeBetween('-30 days', 'now')
    ];
});
