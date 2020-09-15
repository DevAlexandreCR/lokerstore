<?php

/** @var Factory $factory */

use App\Constants\Payments;
use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'status' => Payments::STATUS_PENDING,
        'process_url' => 'https://test.placetopay.com/redirection/session/367482/84c23ca70278d4506768178ca5fb246f',
        'request_id' => 367482
    ];
});
