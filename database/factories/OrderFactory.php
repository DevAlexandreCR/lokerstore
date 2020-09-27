<?php

/** @var Factory $factory */

use App\Constants\Orders;
use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'amount' => $faker->numberBetween(10000, 100000),
        'status' => $faker->randomElement(Orders::getAllStatus())
    ];
});
