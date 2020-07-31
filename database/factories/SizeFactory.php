<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Size;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Size::class, function (Faker $faker) {
    return [
        'name' => Str::random(1)
    ];
});
