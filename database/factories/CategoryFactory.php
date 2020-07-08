<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    $subcategories = [
        'Camisas','Camisetas','Pantalones','Sudaderas','Chaquetas', 'Busos', 'Jeans',
        'Tennis', 'Faldas', 'Vestidos', 'Relojes', 'Gafas'
    ];
    return [
        'name' => $faker->randomElement($subcategories),
        'id_parent' => Category::inRandomOrder()->value('id') ?: null
    ];
});
