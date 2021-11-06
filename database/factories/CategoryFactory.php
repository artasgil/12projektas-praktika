<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->word(10),
        'description' => $faker->sentence(5),
        'shop_id' => rand(1,10)
    ];
});
