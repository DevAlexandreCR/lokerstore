<?php

/** @var Factory $factory */

use App\Models\Photo;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'name' => $faker->image(storage_path('app/public/photos'), 320, 160, null, false),
        'product_id' => \App\Models\Product::all()->random()->id
    ];
});
