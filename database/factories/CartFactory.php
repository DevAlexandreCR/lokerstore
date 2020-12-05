<?php

/** @var Factory $factory */

use App\Models\Cart;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
    ];
});
