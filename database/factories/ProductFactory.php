<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word(10),
        'excertpt' => $faker->sentence(2),
        'description' => $faker->sentence(5),
        'price' => $faker->numberBetween(1,1000),
        'image' => $faker-> imageUrl(200, 200, 'cats'),
        'category_id' => rand(1,10)
    ];
});
