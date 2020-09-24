<?php

/** @var Factory $factory */

use App\Constants\Payments;
use App\Models\Order;
use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'order_id' => Order::all()->random()->id,
        'status' => Payments::STATUS_PENDING,
        'process_url' => $faker->url,
        'request_id' => $faker->randomNumber(6)
    ];
});
