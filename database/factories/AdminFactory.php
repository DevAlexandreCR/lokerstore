<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make(Str::random(10)),
        'remember_token' => Str::random(10),
    ];
});
