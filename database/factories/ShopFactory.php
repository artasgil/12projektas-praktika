<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'title' => $faker->word(10),
        'description' => $faker->sentence(5),
        'email' => $faker->email(),
        'phone' => $faker->phoneNumber(),
        'country' => $faker->country()
    ];
});
