<?php

/** @var Factory $factory */

use App\Models\Payer;
use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Payer::class, function (Faker $faker) {
    return [
        'document'   => $faker->bankAccountNumber,
        'document_type' => 'CC',
        'name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});
