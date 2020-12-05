<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Size;
use App\Models\TypeSize;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Size::class, function (Faker $faker) {
    return [
        'name' => Str::random(1),
        'type_sizes_id' => TypeSize::all()->random()->id,
    ];
});
