<?php

/** @var Factory $factory */

use App\Constants\Orders;
use App\Models\Order;
use App\Models\User;
    use App\Models\Admin\Admin;
    use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id'    => User::all()->random()->id,
        'admin_id'   => Admin::all()->random()->id,
        'amount'     => 0,
        'status'     => Orders::STATUS_PENDING_PAY,
        'created_at' => $faker->dateTimeBetween('-6 months', 'now')
    ];
});
