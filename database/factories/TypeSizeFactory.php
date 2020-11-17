<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TypeSize;
use Faker\Generator as Faker;

$factory->define(TypeSize::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
    ];
});
