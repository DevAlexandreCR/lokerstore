<?php

/** @var Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->sentence(10),
        'stock' => 0,
        'price' => $faker->randomFloat(2, 20000, 200000),
        'id_category' => Category::subCategories()->random()->id,
        'created_at' => $faker->dateTimeBetween('-30 days', 'now')
    ];
});
