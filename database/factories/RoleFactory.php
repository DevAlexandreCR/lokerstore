<?php

/** @var Factory $factory */

use App\Constants\Admins;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Spatie\Permission\Models\Role;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'guard_name' => Admins::GUARDED,
    ];
});
