<?php

/** @var Factory $factory */

use App\Constants\Orders;
use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    $sellers = \App\Models\Admin\Admin::all()->pluck('id')->toArray();
    $sellers[] = null;

    return [
        'user_id'    => User::all()->random()->id,
        'admin_id'   => $faker->randomElement($sellers),
        'amount'     => 0,
        'status'     => Orders::STATUS_PENDING_PAY,
        'created_at' => $faker->dateTimeBetween('-6 months', 'now'),
    ];
});
