<?php

/** @var Factory $factory */

use App\Models\Payer;
use App\Constants\Payments;
use App\Models\Order;
use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'order_id' => Order::all()->random()->id,
        'payer_id' => Payer::all()->random()->id,
        'status' => $faker->randomElement([Payments::STATUS_ACCEPTED, Payments::STATUS_REJECTED]),
        'process_url' => $faker->url,
        'request_id' => $faker->randomNumber(6),
        'reference' => $faker->bankAccountNumber,
        'method' => $faker->creditCardType,
        'last_digit' => '********' . $faker->randomNumber(4),
    ];
});
