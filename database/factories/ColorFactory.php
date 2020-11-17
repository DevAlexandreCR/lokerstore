<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Color;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Color::class, function (Faker $faker) {
    return [
        'name' => Str::random(3),
        'code' => $faker->hexColor,
    ];
});
