<?php

/** @var Factory $factory */

use App\Models\Admin\Admin;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make(Str::random(10)),
        'is_active' => true,
        'remember_token' => Str::random(10),
    ];
});
